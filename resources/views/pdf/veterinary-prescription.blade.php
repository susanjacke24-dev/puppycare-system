<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Receta Veterinaria</title>

    <style>
        body{
            font-family: DejaVu Sans, sans-serif;
            color:#1f2937;
            font-size:14px;
            line-height:1.5;
        }

        .header{
            border-bottom:3px solid #06b6d4;
            padding-bottom:15px;
            margin-bottom:25px;
        }

        .title{
            font-size:28px;
            font-weight:bold;
            color:#0891b2;
        }

        .subtitle{
            color:#6b7280;
            margin-top:5px;
        }

        .section{
            margin-bottom:25px;
        }

        .section-title{
            background:#ecfeff;
            color:#0f766e;
            padding:10px;
            font-weight:bold;
            border-left:5px solid #06b6d4;
            margin-bottom:12px;
        }

        .info-table{
            width:100%;
            border-collapse:collapse;
        }

        .info-table td{
            padding:8px;
            border-bottom:1px solid #e5e7eb;
        }

        .label{
            font-weight:bold;
            width:180px;
            color:#374151;
        }

        .medicine-table{
            width:100%;
            border-collapse:collapse;
            margin-top:10px;
        }

        .medicine-table th{
            background:#0891b2;
            color:white;
            padding:10px;
            text-align:left;
        }

        .medicine-table td{
            border:1px solid #d1d5db;
            padding:10px;
        }

        .footer{
            margin-top:40px;
            text-align:center;
            font-size:12px;
            color:#6b7280;
        }

        .badge{
            display:inline-block;
            background:#cffafe;
            color:#155e75;
            padding:5px 10px;
            border-radius:20px;
            font-size:12px;
            margin-top:5px;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">

        <div class="title">
            PuppyCare
        </div>

        <div class="subtitle">
            Receta y reporte veterinario
        </div>

    </div>

    <!-- INFORMACIÓN GENERAL -->
    <div class="section">

        <div class="section-title">
            Información de la consulta
        </div>

        <table class="info-table">

            <tr>
                <td class="label">Mascota:</td>
                <td>{{ $appointment->patient->pet_name }}</td>
            </tr>

            <tr>
                <td class="label">Especie:</td>
                <td>{{ $appointment->patient->species }}</td>
            </tr>

            <tr>
                <td class="label">Raza:</td>
                <td>{{ $appointment->patient->breed }}</td>
            </tr>

            <tr>
                <td class="label">Propietario:</td>
                <td>{{ $appointment->patient->user->name }}</td>
            </tr>

            <tr>
                <td class="label">Veterinario:</td>
                <td>{{ $appointment->doctor->name }}</td>
            </tr>

            <tr>
                <td class="label">Fecha:</td>
                <td>
                    {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}
                </td>
            </tr>

        </table>

    </div>

    <!-- DIAGNÓSTICO -->
    <div class="section">

        <div class="section-title">
            Diagnóstico
        </div>

        <p>
            {{ $appointment->diagnosis }}
        </p>

    </div>

    <!-- TRATAMIENTO -->
    <div class="section">

        <div class="section-title">
            Tratamiento
        </div>

        <p>
            {{ $appointment->treatment }}
        </p>

    </div>

    <!-- MEDICAMENTOS -->
    <div class="section">

        <div class="section-title">
            Medicamentos recetados
        </div>

        <table class="medicine-table">

            <thead>
                <tr>
                    <th>Medicamento</th>
                    <th>Dosis</th>
                    <th>Frecuencia</th>
                </tr>
            </thead>

            <tbody>

                @foreach($appointment->medicines as $medicine)

                    <tr>

                        <td>
                            {{ $medicine['name'] }}
                        </td>

                        <td>
                            {{ $medicine['dosage'] }}
                        </td>

                        <td>
                            {{ $medicine['frequency'] }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <!-- NOTAS -->
    @if($appointment->notes)

        <div class="section">

            <div class="section-title">
                Observaciones adicionales
            </div>

            <p>
                {{ $appointment->notes }}
            </p>

        </div>

    @endif

    <!-- ESTADO -->
    <div class="section">

        <span class="badge">
            Consulta finalizada correctamente
        </span>

    </div>

    <!-- FOOTER -->
    <div class="footer">

        PuppyCare · Sistema veterinario clínico

        <br><br>

        Documento generado automáticamente.

    </div>

</body>
</html>