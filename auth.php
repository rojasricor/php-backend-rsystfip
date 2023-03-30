<?php

$payload = json_decode(file_get_contents('php://input'));

if (!$payload) {
  http_response_code(400);
  exit('bad request');
}

$username = $payload->username;
$password = $payload->password;

if (empty($username)) {
  echo json_encode([
    'error' => 'Complete el usuario',
  ]);
  return;
}

if (empty($password)) {
  echo json_encode([
    'error' => 'Complete la contraseña',
  ]);
  return;
}

if (strlen($password) < 8) {
  echo json_encode([
    'error' => 'Contraseña demasiado corta',
  ]);
  return;
}

if (strlen($password) > 30) {
  echo json_encode([
    'error' => 'Contraseña inválida',
  ]);
  return;
}

include_once 'vendor/autoload.php';
$userAuth = app\controllers\UserController::auth("$username@itfip.edu.co", $password);

if ($userAuth) {
  echo json_encode([
    'auth' => true,
    'user' => $userAuth,
  ]);
  return;
}

echo json_encode([
  'error' => 'Credenciales incorrectas',
]);
