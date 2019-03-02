<?php

namespace App\DomainServices;

use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Class SMTPServiceContainer
 * @package App\DomainServices
 */
class SMTPServiceContainer
{

    /**
     * @var PHPMailer
     */
    protected $mail;

    /**
     * SMTPServiceContainer constructor.
     * @param PHPMailer $mail
     * @throws Exception
     */
    public function __construct(PHPMailer $mail)
    {
        $this->mail = $mail;
        try {
            $this->mail->isSMTP();
            $this->mail->SMTPAuth = true;
            $this->mail->isHtml(false);
            $this->mail->Encoding = 'base64';
            $this->mail->CharSet = 'UTF-8';
            $this->mail->SMTPSecure = config('mail.encryption');
            $this->mail->Host = config('mail.host');
            $this->mail->Port = config('mail.port');
            $this->mail->Username = config('mail.username');
            $this->mail->Password = config('mail.password');
            $this->mail->setFrom(config('mail.from.address'), config(config('mail.from.name')));
        } catch (Exception $e) {
            Log::error(config('mail.host'). 'Error sending email:' . $this->mail->ErrorInfo);
            throw($e);
        }
    }

    /**
     * @param string $emailAddress
     * @param string $emailSubject
     * @param string $emailBody
     * @return bool
     * @throws Exception
     */
    public function send(string $emailAddress, string $emailSubject, string $emailBody) : bool
    {
        $this->mail->Subject = $emailSubject;
        $this->mail->MsgHTML($emailBody);
        $this->mail->addAddress($emailAddress);
        if (!$this->mail->send()) {
            Log::error($emailSubject . ' email could not been sent. Invalid configuration parameters.');
            return false;
        } else {
            Log::info($emailSubject . ' email has been sent.');
            return true;
        }
    }
}
