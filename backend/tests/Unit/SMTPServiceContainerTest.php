<?php

namespace Tests\Unit;

use App\DomainServices\SMTPServiceContainer;
use PHPMailer\PHPMailer\PHPMailer;
use Tests\TestCase;
use Mockery;

/**
 * Class SMTPServiceContainerTest
 * @package Tests\Unit
 */
class SMTPServiceContainerTest extends TestCase
{
    /**
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function testSend()
    {
        $emailAddress = 'example@gmail.com';
        $invalidEmailAddress = 'invalid';
        $emailSubject = 'Example Subject';
        $emailBody = 'Example Body';

        $mockMailer = Mockery::mock(PHPMailer::class);
        $mockMailer
            ->shouldReceive('isSMTP')
            ->once()
            ->withNoArgs()
            ->andReturnSelf();
        $mockMailer
            ->shouldReceive('isHtml')
            ->once()
            ->with(false)
            ->andReturnSelf();
        $mockMailer
            ->shouldReceive('setFrom')
            ->once()
            ->with(config('mail.from.address'), config(config('mail.from.name')))
            ->andReturnSelf();
        $mockMailer
            ->shouldReceive('msgHTML')
            ->twice()
            ->with($emailBody)
            ->andReturnSelf();
        $mockMailer
            ->shouldReceive('addAddress')
            ->once()
            ->with($emailAddress)
            ->andReturnSelf();
        $mockMailer
            ->shouldReceive('send')
            ->withNoArgs()
            ->once()
            ->andReturnTrue();
        $mockMailer
            ->shouldReceive('addAddress')
            ->once()
            ->with($invalidEmailAddress)
            ->andReturnSelf();
        $mockMailer
            ->shouldReceive('send')
            ->withNoArgs()
            ->once()
            ->andReturnFalse();

        $mail = new SMTPServiceContainer($mockMailer);

        $result = $mail->send($emailAddress, $emailSubject, $emailBody);
        $this->assertTrue($result);

        $result = $mail->send($invalidEmailAddress, $emailSubject, $emailBody);
        $this->assertFalse($result);
    }
}
