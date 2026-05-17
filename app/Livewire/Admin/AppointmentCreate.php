<?php

namespace App\Livewire\Admin;

use App\Mail\AppointmentConfirmed;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Services\AppointmentScheduleValidator;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
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

        $scheduleValidation = AppointmentScheduleValidator::validate(
            (int) $this->doctor_id,
            $this->date,
            $this->start_time,
            $this->end_time
        );

        if (!$scheduleValidation['valid']) {
            $this->notification()->error(
                $title = $scheduleValidation['title'],
                $description = $scheduleValidation['message']
            );
            $this->addError($scheduleValidation['field'], $scheduleValidation['message']);
            return;
        }

        $appointment = Appointment::create([
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->doctor_id,
            'date' => $this->date,
            'start_time' => $scheduleValidation['start_time'],
            'end_time' => $scheduleValidation['end_time'],
            'reason' => $this->reason,
            'status' => 1,
        ]);

        $appointment->load(['patient.user', 'doctor']);

        try {
            Mail::to($appointment->patient->user->email)->send(new AppointmentConfirmed($appointment));
            Mail::to($appointment->doctor->email)->send(new AppointmentConfirmed($appointment));
            WhatsAppService::send($appointment, 'confirmation');
        } catch (\Exception $e) {
            Log::error('Error en notificaciones: ' . $e->getMessage());
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Exito',
            'text' => 'La cita veterinaria ha sido creada correctamente.',
        ]);

        return redirect()->route('admin.appointments.index');
    }

    public function render()
    {
        $patients = Patient::with('user')->get();
        $doctors = User::role('Doctor')->get();

        return view('livewire.admin.appointment-create', compact('patients', 'doctors'));
    }
}
