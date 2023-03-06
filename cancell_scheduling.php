<?php

if (!isset($_GET['id']) || !isset($_GET['date'])) {
  http_response_code(400);
  exit('bad request');
}

include_once 'session_check.php';
$ok = RSystfip\SchedulingController::cancell($_GET['id'], $_GET['date']);

if ($ok) {
  echo json_encode([
    'ok' => 'Cita cancelada exitosamente',
  ]);
  return;
}

echo json_encode([
  'error' => 'Error al cancelar el agendamiento',
]);
