<?php

namespace App\Models;

use Exception;

use SendGrid;

use SendGrid\Mail\Mail;

class EmailSenderModel
{
  private Mail $email;

  private EnvModel $envModelInstance;
  
  public function __construct()
  {
    $this->email = new Mail;
    $this->envModelInstance = new EnvModel;
  }

  public function sendEmail(string $subject, string $to, string $content): bool
  {
    $this->email->setFrom(
      $this->envModelInstance->get('FROM_EMAIL'),
      $this->envModelInstance->get('FROM_NAME')
    );
    $this->email->setSubject($subject);
    $this->email->addTo($to);
    $this->email->addContent("text/html", $content);

    $sendgridApiKey = $this->envModelInstance->get('SENDGRID_API_KEY');
    $sendgrid = new SendGrid($sendgridApiKey);
    
    try {
      $response = $sendgrid->send($this->email);
      return $response->statusCode() === 202;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }
}
