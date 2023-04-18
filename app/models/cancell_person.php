<?php

$payload = json_decode(file_get_contents('php://input'));

if (!$payload) {
  http_response_code(400);
  exit('bad request');
}

$id = $payload->id;
$date = $payload->date;
$cancelled_asunt = $payload->cancelled_asunt;

if (empty($cancelled_asunt)) {
  echo json_encode([
    'error' => 'Complete el motivo de cancelamiento',
  ]);
  return;
}

include_once 'session_check.php';
$ok = App\Controllers\SchedulingController::cancell($id, $date, $cancelled_asunt);

if ($ok) {
  echo json_encode([
    'ok' => 'Cita cancelada exitosamente',
  ]);
  return;
}

echo json_encode([
  'error' => 'Error al cancelar el agendamiento',
]);
