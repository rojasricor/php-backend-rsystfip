<?php

namespace App\Controllers;

use Valitron\Validator;

use App\Models\UserModel;

class AuthController
{
  private UserModel $userModel;

  public function __construct()
  {
    $this->userModel = new UserModel;
  }

  public function auth(): void
  {
    $payload = json_decode(file_get_contents('php://input'));

    if (!$payload) {
      http_response_code(400);
      exit('Bad request');
    }

    $v = new Validator((array) $payload);
    $v->rule('required', ['username', 'password'])
      ->rule('lengthMin', 'username', 1)
      ->rule('lengthMax', 'username', 255)
      ->rule('lengthMin', 'password', 8)
      ->rule('lengthMax', 'password', 30);

    if ($v->validate()) {
      $userAuth = $this->userModel->auth($payload->username . '@itfip.edu.co', $payload->password);

      if ($userAuth) {
        echo json_encode([
          'auth' => true,
          'user' => $userAuth
        ]);
        return;
      }

      echo json_encode([
        'errors' => ['auth' => 'Usuario o contraseña incorrectos'],
      ]);
      return;
    }

    echo json_encode([
      'errors' => $v->errors()
    ]);
  }
}
