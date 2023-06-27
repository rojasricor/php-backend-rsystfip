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

    $v = new Validator((array) $payload);
    $fieldsRequired = [
      'person',
      'name',
      'doctype',
      'doc',
      'facultie',
      'asunt',
      'color',
      'date',
      'start',
      'end',
      'status'
    ];
    
    if ($status === 'scheduled') {
      array_push($fieldsRequired, 'telContact', 'emailContact');
    }

    $v->rule('required', $fieldsRequired)
      ->rule('lengthBetween', 'doc', 8, 10)
      ->rule('email', 'emailContact')
      ->rule('length', 'telContact', 10)
      ->rule('lengthBetween', 'asunt', 10, 150)
      ->rule('notIn', 'person', ['unset'])
      ->rule('numeric', 'doc')
      ->rule('numeric', 'telContact')
      ->rule('notIn', 'doctype', ['unset']);

    if (!$v->validate()) {
      echo json_encode([
        'errors' => $v->errors()
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

    $v = new Validator((array) $payload);
    $v->rule('required', [
      'id',
      'person',
      'name',
      'doctype',
      'doc',
      'facultie',
      'asunt'
    ])->rule('notIn', 'person', ['unset'])
      ->rule('lengthBetween', 'doc', 8, 10)
      ->rule('notIn', 'doctype', ['unset'])
      ->rule('lengthBetween', 'asunt', 10, 150);

    if (!$v->validate()) {
      echo json_encode([
        'errors' => $v->errors()
      ]);
      return;
    }

    $id       = $payload->id;
    $person   = $payload->person;
    $name     = ucwords(strtolower($payload->name));
    $doctype  = $payload->doctype;
    $doc      = $payload->doc;
    $facultie = $payload->facultie;
    $asunt    = ucfirst(strtolower($payload->asunt));

    $personFound = $this->peopleModel->getOneById($id);

    if (!$personFound) {
      echo json_encode([
        'errors' => [
          'error' => 'La persona no existe, ha ocurrido un error'
        ]
      ]);
      return; 
    }

    $ok = $this->peopleModel->update($name, $doctype, $doc, $person, $facultie, $asunt, $id);

    if ($ok) {
      echo json_encode([
        'ok' => 'Persona actualizada exitosamente!',
      ]);
      return;
    }

    echo json_encode([
      'errors' => [
        'error' => 'Nada que actualizar.'
      ]
    ]);
  }

  public function cancellPerson(): void
  {
    $payload = json_decode(file_get_contents('php://input'));

    if (!$payload) {
      http_response_code(400);
      exit('bad request');
    }

    $v = new Validator((array) $payload);
    $v->rule('required', [
      'id',
      'date',
      'cancelled_asunt'
    ])->rule('date', 'date')
      ->rule('lengthBetween', 'cancelled_asunt', 10, 150);

    if (!$v->validate()) {
      echo json_encode([
        'errors' => $v->errors()
      ]);
      return;
    }

    $id = $payload->id;
    $date = $payload->date;
    $cancelled_asunt = $payload->cancelled_asunt;

    $schedulingModel = new SchedulingModel;
    $citeDataFound = $schedulingModel->findCiteById($id);

    if (!$citeDataFound) {
      echo json_encode([
        'errors' => [
          'error' => 'La cita no existe, ha ocurrido un error'
        ]
      ]);
      return;
    }

    $emailSenderModel = new EmailSenderModel;
    $message = "<strong>" . $citeDataFound->name . "</strong>" . " se ha cancelado la cita programada para el día " . "<code>$date</code>" . ". El motivo de cancelación es: " . $cancelled_asunt . ".<br><br>Si tiene alguna duda o comentario, por favor comuníquese con nosotros.<br><br>Saludos,<br>Rectoría ITFIP - RSystfip.<br><br><img src='https://repositorio.itfip.edu.co/themes/Mirage2/images/logo_wh.png'>";

    $cancelledCite = $emailSenderModel->sendEmail(
      "Cita cancelada Rectoria ITFIP - RSystfip",
      $citeDataFound->email,
      $message
    );

    if ($cancelledCite['errors'] ?? false) {
      echo json_encode([
        'errors' => $cancelledCite['errors']
      ]);
      return;
    }

    // Cancelling cite
    $ok = $schedulingModel->cancell($id, $date, $cancelled_asunt);

    if ($cancelledCite['response'] ?? false && $ok) {
      echo json_encode([
        'ok' => 'Cita cancelada exitosamente',
      ]);
      return;
    }

    echo json_encode([
      'errors' => [
        'error' => 'No se pudo cancelar la cita, intente nuevamente.'
      ],
    ]);
  }
}
