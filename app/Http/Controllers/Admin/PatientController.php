<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\BloodType;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.patients.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return view('admin.patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        $bloodTypes = BloodType::all();
        return view('admin.patients.edit', compact('patient', 'bloodTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
     $data = $request->validate([
        'pet_name' => 'nullable|string|min:2|max:255',
        'species' => 'nullable|string|min:2|max:100',
        'breed' => 'nullable|string|min:2|max:100',
        'sex' => 'nullable|string|max:30',
        'birth_date' => 'nullable|date|before_or_equal:today',
        'blood_type_id' => 'nullable|exists:blood_types,id',
        'allergies' => 'nullable|string|min:3|max:255',
        'chronic_conditions' => 'nullable|string|min:3|max:255',
        'surgical_history' => 'nullable|string|min:3|max:255',
        'family_history' => 'nullable|string|min:3|max:255',
        'observations' => 'nullable|string|min:3|max:255',
        'emergency_contact_name' => 'nullable|string|min:3|max:255',
        'emergency_contact_phone' => ['nullable', 'string', 'max:20', 'min:10', 'regex:/^[0-9()\s-]+$/'],
        'emergency_contact_relationship' => 'nullable|string|min:3|max:50',
     ]);

     $patient->update($data);

     session()->flash('swal', [
        'icon' => 'success',
        'title' => 'Mascota actualizada',
        'text' => 'El expediente de la mascota ha sido actualizado exitosamente'
     ]);

     return redirect()
        ->route('admin.patients.edit', $patient)
        ->with('success', 'Mascota actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
