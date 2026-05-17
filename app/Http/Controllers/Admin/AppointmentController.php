<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Barryvdh\DomPDF\Facade\Pdf;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::with(['patient.user', 'doctor'])->get();
        return view('admin.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.appointments.create');
    }

    /**
     * Generate and download the appointment voucher in PDF format.
     */
    public function downloadVoucher(Appointment $appointment)
    {
        // Cargar relaciones para asegurar que los datos estén disponibles en la vista
        $appointment->load(['patient.user', 'doctor']);

        // Generar el PDF usando la vista ya creada
        $pdf = Pdf::loadView('pdf.appointment-voucher', compact('appointment'));

        // Retornar el archivo para descarga inmediata
        return $pdf->download('Comprobante-Cita-Veterinaria-' . $appointment->id . '.pdf');
    }
}
