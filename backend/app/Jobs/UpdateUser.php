<?php

namespace App\Jobs;

use App\DomainServices\SMTPServiceContainer;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class UpdateUser
 * @package App\Jobs
 */
class UpdateUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $emailSubject;

    /**
     * @var string
     */
    protected $emailBody;

    /**
     * @var mixed
     */
    protected $emailAddress;

    /**
     * @var SMTPServiceContainer
     */
    protected $mail;

    /**
     * UpdateUser constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->emailSubject = 'Account update';
        $this->emailBody = $user->id . ' your account has been updated';
        $this->emailAddress = $user->email;
    }

    /**
     * Execute the job.
     *
     * @param SMTPServiceContainer $mail
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function handle(SMTPServiceContainer $mail)
    {
        $mail->send($this->emailAddress, $this->emailSubject, $this->emailBody);
    }
}
