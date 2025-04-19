<?php

namespace Admin\Tech\Includes\Class;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../../vendor/autoload.php';

class Email
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
    }

    protected function sendEmailNotification(
        $toEmail,
        $subject,
        $message
    ) {
        try {
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.gmail.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'dexdasdasdteradobeshop@gmail.com'; // Replace with your Gmail address
            $this->mail->Password = 'dy54gfh4d89'; // Replace with your Gmail password or app-specific password if using 2FA
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port = 587;

            $this->mail->setFrom('sdfsdfeawadawdvxv@gmail.com', 'HR Admin');
            $this->mail->addAddress($toEmail);
            $this->mail->Subject = $subject;
            $this->mail->Body = $message;

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return 'Message could not be sent. Mailer Error: ' . $this->mail->ErrorInfo;
        }
    }

    protected function  error()
    {
        return 'Message could not be sent. Mailer Error: ' . $this->mail->ErrorInfo;
    }
}
