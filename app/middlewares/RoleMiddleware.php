<?php

namespace App\Middlewares;

use App\Models\UserModel;

class RoleMiddleware
{
  private UserModel $userModel;
  private array $roles = [];

  public function __construct(array $roles)
  {
    $this->userModel = new UserModel;
    $this->roles = $roles;
  }

  public function __invoke(): void
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

    if (!in_array($response['ok']['decoded']['role'], $this->roles)) {
      http_response_code(401);
      exit('Unauthorized for do this action');
    }
  }
}
