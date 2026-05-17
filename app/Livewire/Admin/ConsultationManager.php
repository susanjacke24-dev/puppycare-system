<?php

namespace App\Livewire\Admin;

use App\Models\Appointment;
use Livewire\Component;

class ConsultationManager extends Component
{
    public Appointment $appointment;
    
    // Consulta fields
    public $diagnosis;
    public $treatment;
    public $notes;
    
    // Receta fields (JSON)
    public $medicines = [];
    
    // History Modal
    public $pastAppointments = [];

    public function mount(Appointment $appointment)
    {
        $this->appointment = $appointment->load(['patient.user', 'doctor']);
        $this->diagnosis = $appointment->diagnosis;
        $this->treatment = $appointment->treatment;
        $this->notes = $appointment->notes;
        
        // Initialize medicines from DB or empty array
        $this->medicines = $appointment->medicines ?? [];
    }

    /**
     * Adds an empty medicine entry to the list
     */
    public function addMedicine()
    {
        $this->medicines[] = [
            'name' => '',
            'dosage' => '',
            'frequency' => '',
        ];
    }

    /**
     * Removes a medicine entry by its index
     */
    public function removeMedicine($index)
    {
        unset($this->medicines[$index]);
        $this->medicines = array_values($this->medicines);
    }

    /**
     * Loads past appointments for the history modal
     */
    public function loadHistory()
    {
        $this->pastAppointments = Appointment::with('doctor')
            ->where('patient_id', $this->appointment->patient_id)
            ->where('id', '!=', $this->appointment->id)
            ->whereNotNull('diagnosis')
            ->orderBy('date', 'desc')
            ->get();
    }

    /**
     * Validates and saves the consultation data
     */
    public function saveConsultation()
    {
        $this->validate([
            'diagnosis' => 'required|string|min:5',
            'treatment' => 'required|string|min:5',
            'notes' => 'nullable|string',
            'medicines.*.name' => 'required|string',
            'medicines.*.dosage' => 'required|string',
            'medicines.*.frequency' => 'required|string',
        ], [
            'diagnosis.required' => 'El diagnóstico es obligatorio.',
            'treatment.required' => 'El tratamiento es obligatorio.',
            'medicines.*.name.required' => 'El nombre es obligatorio.',
            'medicines.*.dosage.required' => 'La dosis es obligatoria.',
            'medicines.*.frequency.required' => 'La frecuencia es obligatoria.',
        ]);

        $this->appointment->update([
            'diagnosis' => $this->diagnosis,
            'treatment' => $this->treatment,
            'notes' => $this->notes,
            'medicines' => $this->medicines,
            'status' => 2, // 2 = Completado
        ]);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Consulta Finalizada!',
            'text' => 'La cita ha sido marcada como completada.',
        ]);

        return redirect()->route('admin.appointments.index');
    }

    public function render()
    {
        return view('livewire.admin.consultation-manager')
            ->layout('layouts.admin', [
                'title' => 'Consulta veterinaria - ' . ($this->appointment->patient->pet_display_name ?? 'Mascota')
            ]);
    }
}
