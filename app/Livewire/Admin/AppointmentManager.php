<?php

namespace App\Livewire\Admin;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Services\AppointmentScheduleValidator;
use Livewire\Component;

class AppointmentManager extends Component
{
    public $isCreating = false;

    public $patient_id;
    public $doctor_id;
    public $date;
    public $start_time;
    public $end_time;
    public $reason;

    public function rules()
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'reason' => 'nullable|string',
        ];
    }

    public function create()
    {
        $this->reset(['patient_id', 'doctor_id', 'date', 'start_time', 'end_time', 'reason']);
        $this->isCreating = true;
    }

    public function cancel()
    {
        $this->isCreating = false;
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
            $this->addError($scheduleValidation['field'], $scheduleValidation['message']);
            return;
        }

        Appointment::create([
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->doctor_id,
            'date' => $this->date,
            'start_time' => $scheduleValidation['start_time'],
            'end_time' => $scheduleValidation['end_time'],
            'duration' => 15,
            'reason' => $this->reason,
            'status' => 1,
        ]);

        $this->isCreating = false;
        session()->flash('message', 'Cita registrada con exito.');
    }

    public function render()
    {
        $appointments = Appointment::with(['patient.user', 'doctor'])
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();
        $patients = Patient::with('user')->get();
        $doctors = User::role('Doctor')->get();

        return view('livewire.admin.appointment-manager', [
            'appointments' => $appointments,
            'patients' => $patients,
            'doctors' => $doctors,
        ])->layout('layouts.app');
    }
}
