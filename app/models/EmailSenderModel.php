<?php

namespace App\Models;

use Exception;

use SendGrid;

use SendGrid\Mail\Mail;

class EmailSenderModel extends BaseModel
{
  private Mail $email;

  private EnvModel $envModelInstance;
  
  public function __construct()
  {
    parent::__construct();
    $this->email = new Mail;
  }

  public function sendEmail(string $subject, string $to, string $content): array
  {
    $this->email->setFrom($this->env->get('FROM_EMAIL'), $this->env->get('FROM_NAME'));
    $this->email->setSubject($subject);
    $this->email->addTo($to);
    $this->email->addContent("text/html", $content);

    $sendgridApiKey = $this->env->get('SENDGRID_API_KEY');
    $sendgrid = new SendGrid($sendgridApiKey);
    
    try {
      $response = $sendgrid->send($this->email);
      return ['response' => $response->statusCode() === 202];
    } catch (Exception $e) {
      return [
        'errors' => [
          'error' => $e->getMessage()
        ]
      ];
    }
  }
}
