<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DoctorManager extends Component
{
    use WithPagination;

    // Search and UI state
    public $search = '';
    public $isOpen = false;
    public $isEditMode = false;

    // Doctor (User) Form Fields
    public $doctorId;
    public $name;
    public $email;
    public $password;
    public $id_number;
    public $phone;
    public $address;
    public $specialty;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->doctorId)],
            'password' => $this->isEditMode ? 'nullable|min:8' : 'required|min:8',
            'id_number' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'specialty' => 'required|string|max:100',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetForm();
        $this->isEditMode = false;
        $this->isOpen = true;
    }

    public function edit(User $doctor)
    {
        $this->resetForm();
        $this->doctorId = $doctor->id;
        $this->name = $doctor->name;
        $this->email = $doctor->email;
        $this->id_number = $doctor->id_number;
        $this->phone = $doctor->phone;
        $this->address = $doctor->address;
        $this->specialty = $doctor->specialty;
        
        $this->isEditMode = true;
        $this->isOpen = true;
    }

    public function save()
    {
        $this->validate();

        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'id_number' => $this->id_number,
            'phone' => $this->phone,
            'address' => $this->address,
            'specialty' => $this->specialty,
        ];

        if ($this->password) {
            $userData['password'] = Hash::make($this->password);
        }

        if ($this->isEditMode) {
            $doctor = User::findOrFail($this->doctorId);
            $doctor->update($userData);
            $message = 'Veterinario actualizado correctamente.';
        } else {
            $doctor = User::create($userData);
            $doctor->assignRole('Doctor');
            $message = 'Veterinario creado correctamente.';
        }

        $this->isOpen = false;
        $this->resetForm();
        
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Éxito!',
            'text' => $message,
        ]);
    }

    public function delete($id)
    {
        $doctor = User::findOrFail($id);
        $doctor->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Eliminado',
            'text' => 'El registro del veterinario ha sido eliminado.',
        ]);
    }

    private function resetForm()
    {
        $this->reset(['doctorId', 'name', 'email', 'password', 'id_number', 'phone', 'address', 'specialty']);
        $this->resetValidation();
    }

    public function render()
    {
        $doctors = User::role('Doctor')
            ->where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('id_number', 'like', '%' . $this->search . '%')
                      ->orWhere('specialty', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.doctor-manager', [
            'doctors' => $doctors
        ])->layout('layouts.admin');
    }
}
