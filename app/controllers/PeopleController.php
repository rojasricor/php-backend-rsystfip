<?php

namespace App\Controllers;

use Valitron\Validator;

use App\Models\{
  PeopleModel,
  SchedulingModel,
  EmailSenderModel
};

class PeopleController
{
  private PeopleModel $peopleModel;

  public function __construct()
  {
    $this->peopleModel = new PeopleModel;
  }

  public function getPeople(): void
  {
    echo json_encode($this->peopleModel->getAll());
  }

  public function getPerson(): void
  {
    if (!isset($_GET['id'])) {
      http_response_code(400);
      exit('bad request');
    }
    
    $person = $this->peopleModel->getOneById($_GET['id']);
    
    if (!$person) {
      http_response_code(404);
      exit('not found');
    }
    
    echo json_encode($person);    
  }

  public function getCancelled(): void
  {
    echo json_encode($this->peopleModel->getCancelled());
  }

  public function getDeans(): void
  {
    echo json_encode($this->peopleModel->getDeans());
  }

  public function savePerson(): void
  {
    $payload = json_decode(file_get_contents('php://input'));

    if (!$payload) {
      http_response_code(400);
      exit('bad request');
    }

    $person   = $payload->person;
    $name     = ucwords(strtolower($payload->name));
    $doctype  = $payload->doctype;
    $doc      = $payload->doc;
    $telCntct = $payload->telContact;
    $emailCtc = $payload->emailContact;
    $facultie = $payload->facultie;
    $asunt    = ucfirst(strtolower($payload->asunt));
    $color    = $payload->color;
    $date     = $payload->date;
    $start    = $payload->start;
    $end      = $payload->end;
    $status   = $payload->status;

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

    if (!is_null($telCntct) && strlen($telCntct) !== 10) {
      echo json_encode([
        'error' => 'El número de teléfono de contacto debe tener 10 caracteres',
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


    if ($person === '4') {
      $this->peopleModel->saveDeans($doc, $name, $facultie);
    }

    $ok = $this->peopleModel->schedule($name, $doctype, $doc, $person, $telCntct, $emailCtc, $facultie, $asunt, $color, $date, $start, $end, $status);

    if ($ok) {
      echo json_encode([
        'ok' => '¡Registrada con éxito!',
      ]);
    }
  }

  public function updatePerson(): void
  {
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

    $ok = $this->peopleModel->update($name, $doctype, $doc, $person, $facultie, $asunt, $id);

    if ($ok) {
      echo json_encode([
        'ok' => 'Persona actualizada exitosamente!',
      ]);
    }
  }

  public function cancellPerson(): void
  {
    $payload = json_decode(file_get_contents('php://input'));

    if (!$payload) {
      http_response_code(400);
      exit('bad request');
    }

    $id = $payload->id;
    $date = $payload->date;
    $cancelled_asunt = $payload->cancelled_asunt;

    if (empty($cancelled_asunt)) {
      echo json_encode([
        'error' => 'Complete el motivo de cancelamiento',
      ]);
      return;
    }

    $schedulingModel = new SchedulingModel;
    $citeDataFound = $schedulingModel->findCiteById($id);
    $ok = $schedulingModel->cancell($id, $date, $cancelled_asunt);

    if ($citeDataFound && $ok) {
      $emailSenderModel = new EmailSenderModel;
      $message = "<strong>" . $citeDataFound->name . "</strong>" . " se ha cancelado la cita programada para el día " . "<code>$date</code>" . ". El motivo de cancelación es: " . $cancelled_asunt . ".<br><br>Si tiene alguna duda o comentario, por favor comuníquese con nosotros.<br><br>Saludos,<br>Rectoría ITFIP - RSystfip.<br><br><img src='https://repositorio.itfip.edu.co/themes/Mirage2/images/logo_wh.png'>";

      $cancelledCite = $emailSenderModel->sendEmail(
        "Cita cancelada Rectoria ITFIP - RSystfip",
        $citeDataFound->email,
        $message
      );
    
      if ($cancelledCite) {
        echo json_encode([
          'ok' => 'Cita cancelada exitosamente',
        ]);
        return;
      }
    }

    echo json_encode([
      'error' => 'Error al cancelar el agendamiento',
    ]);
  }
}
