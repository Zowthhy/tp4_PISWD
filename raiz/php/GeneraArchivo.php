<?php
if (isset($_GET['fecha']) && isset($_GET['asistencia'])) {
    $fecha = $_GET['fecha'];
    $asistencia = unserialize(urldecode($_GET['asistencia']));
    
    $filename = '../Archivos/' . $fecha . '.txt';
    $file = fopen($filename, 'w');

    foreach ($asistencia as $nro_matricula => $estado) {
        fwrite($file, $nro_matricula . ',' . $estado . PHP_EOL);
    }

    fclose($file);
    echo "Archivo de asistencia para la fecha " . $fecha . " generado exitosamente.";
} else {
    echo "Error: No se recibieron datos válidos.";
}
?>