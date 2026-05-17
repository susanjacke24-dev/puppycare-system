<?php

namespace App\Livewire\Admin;

use App\Mail\AppointmentCancelled;
use App\Models\Appointment;
use App\Services\AppointmentScheduleValidator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class AppointmentIndex extends Component
{
    use WithPagination;
    use WireUiActions;

    public $search = '';
    public $isOpen = false;

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

        $scheduleValidation = AppointmentScheduleValidator::validate(
            (int) $this->doctor_id,
            $this->date,
            $this->start_time,
            $this->end_time,
            (int) $this->appointmentId
        );

        if (!$scheduleValidation['valid']) {
            $this->notification()->error($scheduleValidation['title'], $scheduleValidation['message']);
            $this->addError($scheduleValidation['field'], $scheduleValidation['message']);
            return;
        }

        $appointment = Appointment::findOrFail($this->appointmentId);
        $appointment->update([
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->doctor_id,
            'date' => $this->date,
            'start_time' => $scheduleValidation['start_time'],
            'end_time' => $scheduleValidation['end_time'],
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
            $description = 'Se han procesado los reportes y recordatorios segun las citas de hoy.'
        );
    }

    public function delete($id, $reason = 'No especificado')
    {
        $appointment = Appointment::with(['patient.user', 'doctor'])->findOrFail($id);

        try {
            Mail::to($appointment->patient->user->email)->send(new AppointmentCancelled($appointment, $reason));
            Mail::to($appointment->doctor->email)->send(new AppointmentCancelled($appointment, $reason));
        } catch (\Exception $e) {
            Log::error('Error enviando correo de cancelacion: ' . $e->getMessage());
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
            ->where(function ($query) {
                $query->whereHas('patient', function ($q) {
                    $q->where('pet_name', 'like', '%' . $this->search . '%')
                        ->orWhere('species', 'like', '%' . $this->search . '%')
                        ->orWhere('breed', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($ownerQuery) {
                            $ownerQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                })
                ->orWhereHas('doctor', function ($q) {
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
