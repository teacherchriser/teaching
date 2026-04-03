<?php
// guardar.php
// Guarda las respuestas de la encuesta en un archivo CSV dentro de "data/"
// y redirige al usuario a una página de agradecimiento

// 1) Recoger datos con saneamiento básico
$nombre  = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$correo  = isset($_POST['correo']) ? trim($_POST['correo']) : '';
$opinion = isset($_POST['opinion']) ? trim($_POST['opinion']) : '';

// 2) Validación mínima
if ($nombre === '' || $correo === '' || $opinion === '') {
  http_response_code(400);
  echo "Datos inválidos.";
  exit();
}

// 3) Guardar en CSV dentro de /data
$ruta = __DIR__ . "/data/respuestas-p.csv";
$archivo = fopen($ruta, "a");

if ($archivo === false) {
  http_response_code(500);
  echo "No se pudo abrir el archivo de respuestas.";
  exit();
}

// Si el archivo está vacío, escribe encabezados
if (filesize($ruta) === 0) {
  fputcsv($archivo, ["timestamp", "nombre", "correo", "opinion"]);
}

// Escribe la fila
date_default_timezone_set('America/Bogota');
fputcsv($archivo, [date('Y-m-d H:i:s'), $nombre, $correo, $opinion]);
fclose($archivo);

// 4) Redirige a la página de gracias (cambia la URL a la que quieras)
header("Location: https://chalkboardlp.github.io/");
exit();