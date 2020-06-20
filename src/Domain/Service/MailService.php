<?php

namespace App\Domain\Service;

use \Exception;
use App\Domain\AbstractDomain;
use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;
use GuzzleHttp\Client as Guzzle;

/**
 * Class MailService
 * @package App\Domain\Model
 */
class MailService extends AbstractDomain
{
    /**
     * @param string $subject
     * @param string $from
     * @param string $to
     * @param string $body
     * @return array|null
     * @throws Exception
     */
    public function send(string $subject, string $from, string $to, string $body): ?bool
    {
        try{
            // Create the Transport
            $transport = (new Swift_SmtpTransport('smtp.example.org', 25))
              ->setUsername('your username')
              ->setPassword('your password');

            // Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);

            // Create a message
            $message = (new Swift_Message($subject))
              ->setFrom([$from => $from])
              ->setTo([$to])
              ->setBody($body);

            // Send the message
            return $mailer->send($message);
        } catch (\Exception $e) {
            //throw new \Exception($e->getMessage());
            return null;
        }
    }
}
