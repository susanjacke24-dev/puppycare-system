<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e1e1e1; border-radius: 10px; }
        .header { background-color: #3b82f6; color: white; padding: 10px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 20px; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Confirmacion de Cita Veterinaria</h2>
        </div>
        <div class="content">
            <p>Hola <strong>{{ $appointment->patient->owner_name }}</strong>,</p>
            <p>Se ha confirmado exitosamente una cita veterinaria en <strong>PuppyCare</strong>.</p>
            <p><strong>Detalles de la cita:</strong></p>
            <ul>
                <li><strong>Mascota:</strong> {{ $appointment->patient->pet_display_name }}</li>
                <li><strong>Especie / raza:</strong> {{ $appointment->patient->species ?? 'N/A' }} {{ $appointment->patient->breed ? '/ '.$appointment->patient->breed : '' }}</li>
                <li><strong>Veterinario:</strong> {{ $appointment->doctor->name }}</li>
                <li><strong>Fecha:</strong> {{ $appointment->date->format('d/m/Y') }}</li>
                <li><strong>Hora:</strong> {{ $appointment->start_time }}</li>
                <li><strong>Problema / motivo:</strong> {{ $appointment->reason }}</li>
            </ul>
            <p>Adjunto a este correo encontrara el comprobante oficial en formato PDF.</p>
            <p>Si tiene alguna duda, por favor contactenos.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} PuppyCare. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
