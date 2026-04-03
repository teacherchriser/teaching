<?php
// 1) Recoger datos con saneamiento básico
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$gusto  = isset($_POST['gusto']) ? trim($_POST['gusto']) : '';

// 2) Validación mínima
if ($nombre === '' || ($gusto !== 'si' && $gusto !== 'no')) {
  http_response_code(400);
  echo "Datos inválidos.";
  exit();
}

// 3) Guardar en CSV dentro de /data
$ruta = __DIR__ . "/data/respuestas.csv";
$archivo = fopen($ruta, "a");
error_log("Guardando en: " . $ruta);
if ($archivo === false) {
  http_response_code(500);
  echo "No se pudo abrir el archivo de respuestas.";
  exit();
}

// Si el archivo está vacío, escribe encabezados
if (filesize(__DIR__ . "/data/respuestas.csv") === 0) {
  fputcsv($archivo, ["timestamp", "nombre", "gusto"]);
}

// Escribe la fila
date_default_timezone_set('America/Bogota');
fputcsv($archivo, [date('Y-m-d H:i:s'), $nombre, $gusto]);
fclose($archivo);

// 4) Redirige a la página de gracias (cambia la URL)
header("Location: https://chalkboardlp.com/");
exit();