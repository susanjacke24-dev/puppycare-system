<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Receta Veterinaria</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f4f7fb; padding:30px; color:#1f2937;">

    <div style="
        max-width:700px;
        margin:auto;
        background:white;
        border-radius:12px;
        overflow:hidden;
        box-shadow:0 4px 15px rgba(0,0,0,0.08);
    ">

        <!-- HEADER -->
        <div style="
            background:#0891b2;
            color:white;
            padding:30px;
            text-align:center;
        ">

            <h1 style="margin:0;">
                PuppyCare
            </h1>

            <p style="margin-top:10px;">
                Receta y resumen veterinario
            </p>

        </div>

        <!-- CONTENT -->
        <div style="padding:30px;">

            <p>
                Hola
                <strong>
                    {{ $appointment->patient->user->name }}
                </strong>,
            </p>

            <p>
                La consulta veterinaria de
                <strong>
                    {{ $appointment->patient->pet_name }}
                </strong>
                ha sido finalizada correctamente.
            </p>

            <hr style="margin:25px 0;">

            <h3 style="color:#0891b2;">
                Información de la consulta
            </h3>

            <p>
                <strong>Mascota:</strong>
                {{ $appointment->patient->pet_name }}
            </p>

            <p>
                <strong>Especie:</strong>
                {{ $appointment->patient->species }}
            </p>

            <p>
                <strong>Raza:</strong>
                {{ $appointment->patient->breed }}
            </p>

            <p>
                <strong>Veterinario:</strong>
                {{ $appointment->doctor->name }}
            </p>

            <p>
                <strong>Diagnóstico:</strong><br>
                {{ $appointment->diagnosis }}
            </p>

            <p>
                <strong>Tratamiento:</strong><br>
                {{ $appointment->treatment }}
            </p>

            <hr style="margin:25px 0;">

            <p>
                La receta veterinaria completa se adjunta en formato PDF.
            </p>

            <p>
                Gracias por confiar en PuppyCare.
            </p>

        </div>

        <!-- FOOTER -->
        <div style="
            background:#f1f5f9;
            padding:20px;
            text-align:center;
            font-size:12px;
            color:#6b7280;
        ">

            PuppyCare · Sistema veterinario clínico

        </div>

    </div>

</body>
</html>