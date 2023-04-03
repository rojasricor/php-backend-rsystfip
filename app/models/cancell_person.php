<?php

$payload = json_decode(file_get_contents('php://input'));

if (!$payload) {
  http_response_code(400);
  exit('bad request');
}

$id = $payload->id;
$date = $payload->date;

include_once 'session_check.php';
$ok = app\controllers\SchedulingController::cancell($id, $date);

if ($ok) {
  echo json_encode([
    'ok' => 'Cita cancelada exitosamente',
  ]);
  return;
}

echo json_encode([
  'error' => 'Error al cancelar el agendamiento',
]);
