<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e1e1e1; border-radius: 10px; }
        .header { background-color: #ef4444; color: white; padding: 10px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 20px; }
        .reason-box { background-color: #fef2f2; border-left: 4px solid #ef4444; padding: 15px; margin: 20px 0; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Notificacion de Cancelacion</h2>
        </div>
        <div class="content">
            <p>Hola <strong>{{ $appointment->patient->owner_name }}</strong>,</p>
            <p>Te informamos que la cita veterinaria de <strong>{{ $appointment->patient->pet_display_name }}</strong> ha sido cancelada.</p>

            <div class="reason-box">
                <strong>Motivo de la cancelacion:</strong><br>
                {{ $reason }}
            </div>

            <p><strong>Detalles de la cita que fue cancelada:</strong></p>
            <ul>
                <li><strong>Veterinario:</strong> {{ $appointment->doctor->name }}</li>
                <li><strong>Fecha:</strong> {{ $appointment->date->format('d/m/Y') }}</li>
                <li><strong>Hora:</strong> {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}</li>
            </ul>

            <p>Si consideras que esto es un error o deseas reagendar, por favor contactanos lo antes posible.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
