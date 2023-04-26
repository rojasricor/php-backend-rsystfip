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
    $email->setFrom("rsystfip@gmail.com", "RSystfip");
    $email->setSubject($subject);
    foreach ($to as $t) {
      $email->addTo($t);
    }
    $email->addContent(
      "text/html", "<strong>$content</strong>"
    );
    $sendgrid = new SendGrid('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');
    try {
      $response = $sendgrid->send($email);
      print $response->statusCode() . "\n";
      print_r($response->headers());
      print $response->body() . "\n";
    } catch (Exception $e) {
      echo 'Caught exception: '. $e->getMessage() ."\n";
    }
  }
}