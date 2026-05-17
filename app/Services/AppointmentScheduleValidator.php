<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\DoctorSchedule;
use Carbon\Carbon;

class AppointmentScheduleValidator
{
    public const DAYS = [
        0 => 'DOMINGO',
        1 => 'LUNES',
        2 => 'MARTES',
        3 => 'MIÉRCOLES',
        4 => 'JUEVES',
        5 => 'VIERNES',
        6 => 'SÁBADO',
    ];

    public static function validate(
        int $doctorId,
        string $date,
        string $startTime,
        string $endTime,
        ?int $ignoreAppointmentId = null
    ): array {
        $appointmentDate = Carbon::parse($date);
        $start = Carbon::parse($appointmentDate->toDateString() . ' ' . $startTime);
        $end = Carbon::parse($appointmentDate->toDateString() . ' ' . $endTime);

        if ($end->lte($start)) {
            return [
                'valid' => false,
                'field' => 'end_time',
                'title' => 'Error de horario',
                'message' => 'La hora de fin debe ser posterior a la hora de inicio.',
            ];
        }

        $duration = $start->diffInMinutes($end);

        if ($duration > 60) {
            return [
                'valid' => false,
                'field' => 'end_time',
                'title' => 'Tiempo excedido',
                'message' => "La cita no puede durar mas de 60 minutos. Has seleccionado $duration minutos.",
            ];
        }

        $startTime = $start->format('H:i:s');
        $endTime = $end->format('H:i:s');
        $dayName = self::dayName($appointmentDate);

        $isWithinSchedule = DoctorSchedule::where('doctor_id', $doctorId)
            ->where('day_of_week', $dayName)
            ->where('start_time', '<=', $startTime)
            ->where('end_time', '>=', $endTime)
            ->exists();

        if (!$isWithinSchedule) {
            return [
                'valid' => false,
                'field' => 'start_time',
                'title' => 'Fuera de horario',
                'message' => "El veterinario no labora el dia $dayName en el horario de $startTime a $endTime.",
            ];
        }

        $overlapQuery = Appointment::where('doctor_id', $doctorId)
            ->whereDate('date', $appointmentDate->toDateString())
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where('start_time', '<', $endTime)
                    ->where('end_time', '>', $startTime);
            })
            ->where('status', '!=', 3);

        if ($ignoreAppointmentId) {
            $overlapQuery->where('id', '!=', $ignoreAppointmentId);
        }

        if ($overlapQuery->exists()) {
            return [
                'valid' => false,
                'field' => 'start_time',
                'title' => 'Horario ocupado',
                'message' => 'El veterinario ya tiene una cita programada en este horario.',
            ];
        }

        return [
            'valid' => true,
            'day' => $dayName,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ];
    }

    public static function dayName(Carbon $date): string
    {
        return self::DAYS[$date->dayOfWeek] ?? 'LUNES';
    }

    public static function weekDays(): array
    {
        return array_values([
            self::DAYS[1],
            self::DAYS[2],
            self::DAYS[3],
            self::DAYS[4],
            self::DAYS[5],
            self::DAYS[6],
            self::DAYS[0],
        ]);
    }
}
