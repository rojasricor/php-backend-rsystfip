<?php

$payload = json_decode(file_get_contents('php://input'));

if (!$payload) {
  http_response_code(400);
  exit('bad request');
}

$id       = $payload->id;
$person   = $payload->person;
$name     = ucwords(strtolower($payload->name));
$doctype  = $payload->doctype;
$doc      = $payload->doc;
$facultie = $payload->facultie;
$asunt    = ucfirst(strtolower($payload->asunt));

if (empty($id) || !is_numeric($id)) {
  echo json_encode([
    'error' => 'Estas intentando hacer algo? ojo con eso.',
  ]);
  return;
}

if ($person === 'unset' || empty($person)) {
  echo json_encode([
    'error' => 'Seleccione el tipo de persona a agendar',
  ]);
  return;
}

if (!is_numeric($doc) || empty($doc)) {
  echo json_encode([
    'error' => 'Ingrese el número de documento o cédula',
  ]);
  return;
}

if (strlen($doc) < 8 || strlen($doc) > 10) {
  echo json_encode([
    'error' => 'El número de documento debe tener mas de 8 y menos de 10 caracteres',
  ]);
  return;
}

if ($doctype === 'unset' || empty($doctype)) {
  echo json_encode([
    'error' => 'Debe seleccionar el tipo de documento',
  ]);
  return;
}

if (empty($name)) {
  echo json_encode([
    'error' => 'Complete el campo nombre',
  ]);
  return;
}

if (!ctype_alpha($name) && ctype_space($name)) {
  echo json_encode([
    'error' => 'El nombre sólo puede contener letras',
  ]);
  return;
}

if (is_numeric($name)) {
  echo json_encode([
    'error' => 'El nombre no puede ser numérico',
  ]);
  return;
}

if ($person !== '5' && ($facultie === 'unset' || empty($facultie))) {
  echo json_encode([
    'error' => 'Debe seleccionar la facultad a la que pertenece',
  ]);
  return;
}

$facultie === 'unset' && $facultie = '4';

if (empty($asunt)) {
  echo json_encode([
    'error' => 'Ingrese el motivo de la visita a la Rectoría - ITFIP (sólo texto)',
  ]);
  return;
}

if (!ctype_alpha($asunt) && ctype_space($asunt)) {
  echo json_encode([
    'error' => 'El asunto sólo puede contener letras',
  ]);
  return;
}

if (is_numeric($asunt) || !is_string($asunt)) {
  echo json_encode([
    'error' => 'El asunto no puede ser numérico',
  ]);
  return;
}

include_once 'session_check.php';
$ok = RSystfip\PeopleController::update($name, $doctype, $doc, $person, $facultie, $asunt, $id);

if ($ok) {
  echo json_encode([
    'ok' => 'Persona actualizada exitosamente!',
  ]);
}
