<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController
{
  public static function auth()
  {
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

    $userAuth = UserModel::auth("$username@itfip.edu.co", $password);

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
  }
}
