<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; border-bottom: 2px solid #3b82f6; padding-bottom: 10px; }
        .content { margin-top: 20px; }
        .footer { margin-top: 30px; font-size: 10px; text-align: center; color: #6b7280; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { text-align: left; padding: 8px; border-bottom: 1px solid #e5e7eb; }
        th { background-color: #f9fafb; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Comprobante de Cita Veterinaria</h1>
        <p>PuppyCare - Sistema de Gestion Veterinaria</p>
    </div>

    <div class="content">
        <p>Se ha agendado una nueva cita con los siguientes detalles:</p>
        <table>
            <tr>
                <th>Mascota</th>
                <td>{{ $appointment->patient->pet_display_name }}</td>
            </tr>
            <tr>
                <th>Especie / Raza</th>
                <td>{{ $appointment->patient->species ?? 'N/A' }} {{ $appointment->patient->breed ? '/ '.$appointment->patient->breed : '' }}</td>
            </tr>
            <tr>
                <th>Dueño</th>
                <td>{{ $appointment->patient->owner_name }}</td>
            </tr>
            <tr>
                <th>Veterinario</th>
                <td>{{ $appointment->doctor->name }} ({{ $appointment->doctor->specialty }})</td>
            </tr>
            <tr>
                <th>Fecha</th>
                <td>{{ $appointment->date->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Hora</th>
                <td>{{ $appointment->start_time }}</td>
            </tr>
            <tr>
                <th>Problema / motivo</th>
                <td>{{ $appointment->reason }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Este es un comprobante automatico generado por PuppyCare.</p>
        <p>Por favor, llegue 15 minutos antes de su cita.</p>
    </div>
</body>
</html>
