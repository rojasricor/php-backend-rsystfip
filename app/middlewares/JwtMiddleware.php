<?php

namespace App\Middlewares;

use App\Services\JwtService; // Importa la clase JwtService o cualquier clase que estés usando para trabajar con JWT
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Laminas\Diactoros\Response\JsonResponse;

class JwtMiddleware
{
  public function __invoke(Request $request, RequestHandler $handler)
  {
    // Obtén el token de autorización del encabezado de la solicitud
    $authorizationHeader = $request->getHeaderLine('Authorization');

    // Verifica si el encabezado de autorización está presente y tiene el formato correcto
    if ($authorizationHeader && preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
      $token = $matches[1]; // Obtén el token de la coincidencia

      // Verifica el token usando tu servicio de JWT (JwtService)
      $jwtService = new JwtService(); // Reemplaza JwtService con el nombre de tu clase
      $isValidToken = $jwtService->validateToken($token); // Implementa el método validateToken en tu servicio de JWT

      if ($isValidToken) {
        // Token válido, permite que la solicitud continúe al siguiente middleware o controlador
        return $handler->handle($request);
      }
    }

    // El token no es válido, devuelve una respuesta de error
    $response = new JsonResponse(['error' => 'Invalid token'], 401);
    return $response;
  }
}
