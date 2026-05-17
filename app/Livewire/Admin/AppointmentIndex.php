<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Appointment;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentCancelled;
use Illuminate\Support\Facades\Artisan;

class AppointmentIndex extends Component
{
    use WithPagination;
    use WireUiActions;

    public $search = '';
    public $isOpen = false;

    // Form fields for editing
    public $appointmentId;
    public $patient_id;
    public $doctor_id;
    public $date;
    public $start_time;
    public $end_time;
    public $reason;

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $this->appointmentId = $appointment->id;
        $this->patient_id = $appointment->patient_id;
        $this->doctor_id = $appointment->doctor_id;
        $this->date = $appointment->date->format('Y-m-d');
        $this->start_time = $appointment->start_time;
        $this->end_time = $appointment->end_time;
        $this->reason = $appointment->reason;

        $this->isOpen = true;
    }

    public function save()
    {
        $this->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);
        $this_start_str = $start->format('H:i:s');
        $this_end_str = $end->format('H:i:s');

        // 1. Validar Duración
        if ($start->diffInMinutes($end) > 60) {
            $this->notification()->error('Error', 'La cita no puede durar más de una hora.');
            return;
        }

        // 2. Validar Horario Laboral
        $dayName = $this->getSpanishDayName($start->dayOfWeek);
        $isWithinSchedule = \App\Models\DoctorSchedule::where('doctor_id', $this->doctor_id)
            ->where('day_of_week', $dayName)
            ->where('start_time', '<=', $this_start_str)
            ->where('end_time', '>=', $this_end_str)
            ->exists();

        if (!$isWithinSchedule) {
            $this->notification()->error('Fuera de Horario', 'El veterinario no labora en este horario.');
            return;
        }

        // 3. Validar Traslape (Excluyendo la cita actual)
        $overlap = Appointment::where('doctor_id', $this->doctor_id)
            ->where('date', $this->date)
            ->where('id', '!=', $this->appointmentId)
            ->where(function ($query) use ($this_start_str, $this_end_str) {
                $query->where('start_time', '<', $this_end_str)
                      ->where('end_time', '>', $this_start_str);
            })
            ->where('status', '!=', 3)
            ->exists();

        if ($overlap) {
            $this->notification()->warning('Ocupado', 'Ya existe otra cita en este horario.');
            return;
        }

        $appointment = Appointment::findOrFail($this->appointmentId);
        $appointment->update([
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->doctor_id,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'reason' => $this->reason,
        ]);

        $this->isOpen = false;
        $this->notification()->success('Cita actualizada', 'Los datos de la cita veterinaria han sido modificados.');
    }

    public function sendManualReport()
    {
        Artisan::call('puppycare:automate');
        
        $this->notification()->success(
            $title = 'Reporte Solicitado',
            $description = 'Se han procesado los reportes y recordatorios según las citas de hoy.'
        );
    }

    private function getSpanishDayName($dayNumber)
    {
        $days = [0 => 'DOMINGO', 1 => 'LUNES', 2 => 'MARTES', 3 => 'MIÉRCOLES', 4 => 'JUEVES', 5 => 'VIERNES', 6 => 'SÁBADO'];
        return $days[$dayNumber] ?? 'LUNES';
    }

    public function delete($id, $reason = 'No especificado')
    {
        $appointment = Appointment::with(['patient.user', 'doctor'])->findOrFail($id);

        try {
            // Enviamos el correo de cancelación ANTES de borrar el registro
            Mail::to($appointment->patient->user->email)->send(new AppointmentCancelled($appointment, $reason));
            Mail::to($appointment->doctor->email)->send(new AppointmentCancelled($appointment, $reason));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error enviando correo de cancelación: " . $e->getMessage());
        }

        $appointment->delete();

        $this->notification()->success(
            $title = 'Cita eliminada',
            $description = 'La cita ha sido removida y se ha notificado a las partes.'
        );
    }

    public function render()
    {
        $appointments = Appointment::with(['patient.user', 'doctor'])
            ->where(function($query) {
                $query->whereHas('patient', function($q) {
                    $q->where('pet_name', 'like', '%' . $this->search . '%')
                        ->orWhere('species', 'like', '%' . $this->search . '%')
                        ->orWhere('breed', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($ownerQuery) {
                            $ownerQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                })
                ->orWhereHas('doctor', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(10);

        $patients = \App\Models\Patient::with('user')->get();
        $doctors = \App\Models\User::role('Doctor')->get();

        return view('livewire.admin.appointment-index', [
            'appointments' => $appointments,
            'patients' => $patients,
            'doctors' => $doctors,
        ])->layout('layouts.admin');
    }
}
