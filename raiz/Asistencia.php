<?php
// Leer los datos del archivo Alumnos.txt
$alumnos = file('Archivos/Alumnos.txt');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que el campo fecha no esté vacío
    if (!empty($_POST['fecha'])) {
        $fecha = $_POST['fecha'];
        $asistencia = [];

        // Recorrer la lista de alumnos para obtener su asistencia
        foreach ($alumnos as $alumno) {
            $nro_matricula = explode(',', $alumno)[0]; // Obtener número de matrícula
            $asistencia[$nro_matricula] = $_POST['asistencia'][$nro_matricula];
        }

        // Redirigir a GeneraArchivo.php con los datos de asistencia y la fecha
        header('Location: php/GeneraArchivo.php?fecha=' . urlencode($fecha) . '&asistencia=' . urlencode(serialize($asistencia)));
        exit();
    } else {
        echo "<p style='color:red;'>¡Por favor, seleccione una fecha!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Toma de Asistencia</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Toma de Asistencia</h1>
    <form method="POST" action="Asistencia.php">
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" required><br><br>

        <h2>Lista de Alumnos</h2>
        <table>
            <thead>
                <tr>
                    <th>Nro. de Matrícula</th>
                    <th>Nombre Completo</th>
                    <th>Presente</th>
                    <th>Ausente</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alumnos as $alumno): ?>
                    <?php
                    $detalles = explode(',', $alumno);
                    $nro_matricula = $detalles[0];
                    $nombre_completo = $detalles[1] . ' ' . $detalles[2];
                    ?>
                    <tr>
                        <td><?php echo $nro_matricula; ?></td>
                        <td><?php echo $nombre_completo; ?></td>
                        <td>
                            <input type="radio" name="asistencia[<?php echo $nro_matricula; ?>]" value="P" required>
                        </td>
                        <td>
                            <input type="radio" name="asistencia[<?php echo $nro_matricula; ?>]" value="A">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <br><button type="submit">Guardar Asistencia</button>
    </form>
</body>
</html>
