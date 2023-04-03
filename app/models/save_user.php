<?php

$payload = json_decode(file_get_contents('php://input'));

if (!$payload) {
  http_response_code(400);
  exit('bad request');
}

$role                 = $payload->role;
$name                 = ucwords(strtolower($payload->name));
$lastname             = ucwords(strtolower($payload->lastname));
$documentType         = $payload->docType;
$document             = $payload->doc;
$telephone            = $payload->tel;
$email                = strtolower($payload->email);
$password             = $payload->password;
$passwordConfirmation = $payload->passwordConfirmation;

if ($role !== '2' && $role !== '3') {
  echo json_encode([
    'error' => 'Selecciona el cargo del nuevo usuario',
  ]);
  return;
}

if (empty($name)) {
  echo json_encode(['error' => 'Complete el campo nombre']);
  return;
}

if (!ctype_alpha($name) && ctype_space($name)) {
  echo json_encode(['error' => 'El nombre no debe contener letras']);
  return;
}

if (is_numeric($name)) {
  echo json_encode(['error' => 'El nombre no puede ser numérico']);
  return;
}

if (empty($lastname)) {
  echo json_encode(['error' => 'Complete el campo apellido']);
  return;
}

if (!ctype_alpha($lastname) && ctype_space($lastname)) {
  echo json_encode(['error' => 'El apellido no debe contener letras']);
  return;
}

if (is_numeric($lastname)) {
  echo json_encode(['error' => 'El apellido no puede ser numérico']);
  return;
}

if ($documentType === 'unset' || empty($documentType)) {
  echo json_encode([
    'error' => 'Selecciona el tipo de documento',
  ]);
  return;
}

if (!is_numeric($document) || empty($document)) {
  echo json_encode(['error' => 'Ingrese el número de documento']);
  return;
}

if (strlen($document) < 8 || strlen($document) > 10) {
  echo json_encode(['error' => 'El número de documento debe tener entre 8 y 10 caracteres']);
  return;
}

if (empty($email)) {
  echo json_encode(['error' => 'Ingrese el correo institucional']);
  return;
}

if (is_numeric($email)) {
  echo json_encode(['error' => 'El correo institucional no puede ser sólo números']);
  return;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo json_encode(['error' => 'La dirección de correo electrónico no es válida']);
  return;
}

$domainRequired   = 'itfip.edu.co';
$domainToValidate = explode('@', $email)[1];

if ($domainToValidate !== $domainRequired) {
  echo json_encode(['error' => 'El correo proporcionado no es del dominio ' . $domainRequired]);
  return;
}

if (!is_numeric($telephone) || empty($telephone)) {
  echo json_encode(['error' => 'Ingrese el número de teléfono']);
  return;
}

if (strlen($telephone) !== 10) {
  echo json_encode(['error' => 'El número de celular debe tener 10 dígitos, si usted no es de Colombia ingrese 10 veces 1 para continuar']);
  return;
}

if (empty($password)) {
  echo json_encode(['error' => 'Complete campo contraseña']);
  return;
}

if (empty($passwordConfirmation)) {
  echo json_encode(['error' => 'Complete campo confirmación de contraseña']);
  return;
}

if (strlen($password) < 8 || strlen($passwordConfirmation) < 8) {
  echo json_encode(['error' => 'La contraseña es insegura debe tener al menos 8 caracteres']);
  return;
}

if ($password !== $passwordConfirmation) {
  echo json_encode([
    'error' => 'Las contraseñas no coinciden, password != passwordConfirmation',
  ]);
  return;
}

include_once 'session_check.php';
use App\controllers\UserController as uc;

$id         = $role - 1;
$roleExists = uc::getOneById($id);

if ($roleExists) {
  echo json_encode([
    'error' => 'El cargo seleccionado ya ha sido asignado a otro usuario',
  ]);
  return;
}

$emailExists = uc::getOneByEmail($email);

if ($emailExists) {
  echo json_encode([
    'error' => 'El correo proporcionado ya esta registrado en nombre de otro usuario',
  ]);
  return;
}

$permissions = uc::definePermissionsByRole($role);
$ok = uc::create($id, $role, $name, $lastname, $documentType, $document, $telephone, $email, $password, $permissions);

if ($ok) {
  echo json_encode([
    'ok' => 'Usuario agregado exitosamente!',
  ]);
}
