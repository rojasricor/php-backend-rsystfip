<?php

$payload = json_decode(file_get_contents('php://input'));

if (!$payload) {
  http_response_code(400);
  exit('bad request');
}

$id                 = $payload->id;
$currentPassword    = $payload->current_password;
$newPassword        = $payload->new_password;
$confirmNewPassword = $payload->new_password_confirm;

if ($newPassword !== $confirmNewPassword) {
  echo json_encode([
    'error' => 'La nueva contraseña no coincide con la confirmación',
  ]);
  return;
}

include_once 'session_check.php';
use App\Controllers\UserController as uc;

if (!uc::authById($id, $currentPassword)) {
  echo json_encode([
    'error' => 'La contraseña antigua es incorrecta',
  ]);
  return;
}

uc::updatePassword($id, $newPassword);
echo json_encode([
  'ok' => 'Contraseña cambiada exitosamente',
]);
