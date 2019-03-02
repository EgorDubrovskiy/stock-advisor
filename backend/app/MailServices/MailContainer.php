<?php

namespace App\MailServices;

use phpDocumentor\Reflection\Types\Boolean;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class MailContainer
 * @package App\MailServices
 */
class MailContainer
{
    /** @var PHPMailer $mail */
    protected $mail;

    /**
     * MailContainer constructor.
     * @param PHPMailer $mail
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function __construct(PHPMailer $mail)
    {
        $this->mail = $mail;
        $this->mail->isSMTP();
        $this->mail->SMTPAuth = true;
        $this->mail->isHTML(false);
        $this->mail->Encoding = 'base64';
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Host = config('mail.host');
        $this->mail->Username = config('mail.username');
        $this->mail->Password = config('mail.password');
        $this->mail->SMTPSecure = config('mail.encryption');
        $this->mail->Port = config('mail.port');
        $this->mail->setFrom(config('mail.from.address'), config('mail.from.name'));
    }

    /**
     * @param bool $value
     */
    public function setIsHTML(bool $value) : void
    {
        $this->mail->isHTML($value);
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject) : void
    {
        $this->mail->Subject = $subject;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body) : void
    {
        $this->mail->Body = $body;
    }

    /**
     * @param string $email
     * @param string|null $name
     */
    public function addRecipient(string $email, string $name = null) : void
    {
        is_null($name) ? $this->mail->addAddress($email) : $this->mail->addAddress($email, $name);
    }

    /**
     * @param string $email
     */
    public function addCC(string $email)
    {
        $this->mail->addCC($email);
    }

    /**
     * @param string $path
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function addAttachment(string $path) : void
    {
        $this->mail->addAttachment($path);
    }

    /**
     * @return bool|string
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function send()
    {
        if (!$this->mail->send()) {
            return $this->mail->ErrorInfo;
        }
        return true;
    }
}
