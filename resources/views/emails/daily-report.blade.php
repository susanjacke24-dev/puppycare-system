<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .header { background-color: #1e293b; color: white; padding: 15px; text-align: center; }
        .content { padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f8fafc; font-size: 12px; text-transform: uppercase; }
        .footer { font-size: 11px; text-align: center; margin-top: 30px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $type === 'admin' ? 'Resumen General de Citas Veterinarias' : 'Tu Agenda para Hoy' }}</h2>
        <p>{{ now()->format('l, d \d\e F \d\e Y') }}</p>
    </div>

    <div class="content">
        @if($type === 'doctor')
            <p>Hola <strong>{{ $doctor->name }}</strong>,</p>
            <p>A continuacion se detalla la lista de mascotas agendadas para consulta el dia de hoy:</p>
        @else
            <p>Estimado Administrador,</p>
            <p>Este es el reporte consolidado de todas las citas veterinarias programadas para el dia de hoy:</p>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Hora</th>
                    <th>Mascota</th>
                    <th>Dueño</th>
                    @if($type === 'admin')
                        <th>Veterinario</th>
                    @endif
                    <th>Problema / motivo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $app)
                    <tr>
                        <td>{{ $app->start_time }}</td>
                        <td>{{ $app->patient->pet_display_name }}</td>
                        <td>{{ $app->patient->owner_name }}</td>
                        @if($type === 'admin')
                            <td>{{ $app->doctor->name }}</td>
                        @endif
                        <td>{{ $app->reason }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Este es un reporte automatico generado por el sistema PuppyCare a las 08:00 AM.</p>
    </div>
</body>
</html>
