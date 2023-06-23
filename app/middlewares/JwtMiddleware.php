<?php

namespace App\Middlewares;

use App\Models\UserModel;

class JwtMiddleware
{
  private UserModel $userModel;

  public function __construct()
  {
    $this->userModel = new UserModel;
  }

  public function __invoke()
  {
    $headers = getallheaders();
    $jwt = $headers['Authorization'] ?? '';

    if (!$jwt) {
      http_response_code(401);
      exit('Not session provided');
    }

    $response = $this->userModel->verifyJWT($jwt);
    $ok = $response['ok'] ?? false;

    if (!$ok) {
      http_response_code(401);
      exit($response['message']);
    }
  }
}
