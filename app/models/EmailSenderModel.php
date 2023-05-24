<?php

namespace App\Models;

use Exception;

use SendGrid;

use SendGrid\Mail\Mail;

class EmailSenderModel
{
  public function sendEmail($subject, $to, $content)
  {
    $email = new Mail();
    $envModelInstance = new EnvModel();
    $email->setFrom(
      $envModelInstance->get('FROM_EMAIL'),
      $envModelInstance->get('FROM_NAME')
    );
    $email->setSubject($subject);
    $email->addTo($to);
    $email->addContent("text/html", $content);

    $sendgridApiKey = $envModelInstance->get('SENDGRID_API_KEY');
    $sendgrid = new SendGrid($sendgridApiKey);

    try {
      $response = $sendgrid->send($email);
      return $response;
    } catch (Exception $e) {
      echo json_encode($e->getMessage());
    }
  }
}
