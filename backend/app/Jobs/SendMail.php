<?php

namespace App\Jobs;

use App\MailServices\MailContainer;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class SendMail
 * @package App\Jobs
 * @property string $recipientEmail
 * @property string $subject
 * @property string $message
 */
class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var string $recipientEmail */
    protected $recipientEmail;

    /** @var string $subject */
    protected $subject;

    /** @var string $message */
    protected $message;

    /** @var string */
    protected $cc;


    /**
     * SendMail constructor.
     * @param string $recipientEmail
     * @param string $subject
     * @param string $message
     * @param string|null $cc
     */
    public function __construct(string $recipientEmail, string $subject, string $message, string $cc = null)
    {
        $this->recipientEmail = $recipientEmail;
        $this->subject = $subject;
        $this->message = $message;
        $this->cc = $cc;
    }

    /**
     * @param MailContainer $mail
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function handle(MailContainer $mail) : void
    {
        $mail->addRecipient($this->recipientEmail);
        $mail->setSubject($this->subject);
        $mail->setBody($this->message);
        if($this->cc !== null) {
            $mail->AddCC($this->cc);
        }
        $mail->send();
    }
}
