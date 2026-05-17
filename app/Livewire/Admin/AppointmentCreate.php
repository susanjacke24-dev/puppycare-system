<?php

namespace App\Livewire\Admin;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Models\DoctorSchedule;
use Livewire\Component;
use App\Mail\AppointmentConfirmed;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use WireUi\Traits\WireUiActions;

class AppointmentCreate extends Component
{
    use WireUiActions;

    public $patient_id;
    public $doctor_id;
    public $date;
    public $start_time;
    public $end_time;
    public $reason;

    protected function rules()
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required',
            'reason' => 'required|string',
        ];
    }

    public function save()
    {
        $this->validate();

        // Parseamos las horas para comparar
        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);

        // 1. Validar que la hora de fin sea después de la de inicio
        if ($end->lte($start)) {
            $this->notification()->error(
                $title = 'Error de horario',
                $description = 'La hora de fin debe ser posterior a la hora de inicio.'
            );
            $this->addError('end_time', 'Hora inválida.');
            return;
        }

        // 2. Calcular diferencia real en minutos
        $diff = $start->diffInMinutes($end);

        if ($diff > 60) {
            $this->notification()->error(
                $title = 'Tiempo excedido',
                $description = "La cita no puede durar mas de 60 minutos. (Has seleccionado $diff min)."
            );
            $this->addError('end_time', "Máximo 1 hora permitido.");
            return;
        }

        $this_start_str = $start->format('H:i:s');
        $this_end_str = $end->format('H:i:s');

        // 3. Validar contra el horario laboral del veterinario
        $dayOfWeek = Carbon::parse($this->date)->dayOfWeek;
        $dayName = $this->getSpanishDayName($dayOfWeek);

        $isWithinSchedule = DoctorSchedule::where('doctor_id', $this->doctor_id)
            ->where('day_of_week', $dayName)
            ->where('start_time', '<=', $this_start_str)
            ->where('end_time', '>=', $this_end_str)
            ->exists();

        if (!$isWithinSchedule) {
            $this->notification()->error(
                $title = 'Fuera de horario',
                $description = "El veterinario no labora los dias $dayName en el rango de $this_start_str a $this_end_str."
            );
            $this->addError('start_time', 'El veterinario no esta disponible en este horario laboral.');
            return;
        }

        // 4. VALIDAR TRASLAPE (HORARIO OCUPADO POR OTRA CITA)
        $overlap = Appointment::where('doctor_id', $this->doctor_id)
            ->where('date', $this->date)
            ->where(function ($query) use ($this_start_str, $this_end_str) {
                $query->where('start_time', '<', $this_end_str)
                      ->where('end_time', '>', $this_start_str);
            })
            ->where('status', '!=', 3) // No contar citas canceladas
            ->exists();

        if ($overlap) {
            $this->notification()->warning(
                $title = 'Horario ocupado',
                $description = 'El veterinario ya tiene una cita programada en este horario.'
            );
            $this->addError('start_time', 'Horario no disponible.');
            return;
        }

        // Si llegamos aquí, la validación es correcta y guardamos
        $appointment = Appointment::create([
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->doctor_id,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'reason' => $this->reason,
            'status' => 1,
        ]);

        $appointment->load(['patient.user', 'doctor']);

        try {
            Mail::to($appointment->patient->user->email)->send(new AppointmentConfirmed($appointment));
            Mail::to($appointment->doctor->email)->send(new AppointmentConfirmed($appointment));
            WhatsAppService::send($appointment, 'confirmation');
        } catch (\Exception $e) {
            Log::error("Error en notificaciones: " . $e->getMessage());
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Éxito!',
            'text' => 'La cita veterinaria ha sido creada correctamente.',
        ]);

        return redirect()->route('admin.appointments.index');
    }

    /**
     * Mapea el número del día de la semana de Carbon al nombre en español.
     */
    private function getSpanishDayName($dayNumber)
    {
        $days = [
            0 => 'DOMINGO',
            1 => 'LUNES',
            2 => 'MARTES',
            3 => 'MIÉRCOLES',
            4 => 'JUEVES',
            5 => 'VIERNES',
            6 => 'SÁBADO',
        ];

        return $days[$dayNumber] ?? 'LUNES';
    }

    public function render()
    {
        $patients = Patient::with('user')->get();
        $doctors = User::role('Doctor')->get();

        return view('livewire.admin.appointment-create', compact('patients', 'doctors'));
    }
}
