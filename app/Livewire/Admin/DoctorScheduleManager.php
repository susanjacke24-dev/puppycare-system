<?php

namespace App\Livewire\Admin;

use App\Models\DoctorSchedule;
use App\Models\User;
use App\Services\AppointmentScheduleValidator;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class DoctorScheduleManager extends Component
{
    use WireUiActions;

    public $doctor;
    public $schedules = [];
    public $days = [];

    public $new_day = 'LUNES';
    public $new_start = '08:00';
    public $new_end = '14:00';

    public function mount(User $doctor)
    {
        $this->doctor = $doctor;
        $this->days = AppointmentScheduleValidator::weekDays();
        $this->loadSchedules();
    }

    public function loadSchedules()
    {
        $this->schedules = DoctorSchedule::where('doctor_id', $this->doctor->id)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week')
            ->toArray();
    }

    public function addRange()
    {
        $this->validate([
            'new_day' => 'required|in:' . implode(',', AppointmentScheduleValidator::weekDays()),
            'new_start' => 'required',
            'new_end' => 'required|after:new_start',
        ]);

        DoctorSchedule::create([
            'doctor_id' => $this->doctor->id,
            'day_of_week' => $this->new_day,
            'start_time' => $this->new_start,
            'end_time' => $this->new_end,
        ]);

        $this->loadSchedules();
        $this->notification()->success('Rango anadido', 'Jornada laboral registrada correctamente.');
    }

    public function removeRange($id)
    {
        DoctorSchedule::find($id)?->delete();
        $this->loadSchedules();
        $this->notification()->info('Rango eliminado', 'El turno ha sido removido.');
    }

    public function render()
    {
        return view('livewire.admin.doctor-schedule-manager')->layout('layouts.admin');
    }
}
