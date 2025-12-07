<?php

namespace App\Mail;

use Brevo\Client\Configuration;
use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\MessageConverter;

class BrevoApiTransport implements TransportInterface
{
    protected $apiKey;
    protected $api;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $apiKey);
        $this->api = new TransactionalEmailsApi(new Client(), $config);
    }

    public function send(\Symfony\Component\Mime\RawMessage $message, ?\Symfony\Component\Mailer\Envelope $envelope = null): ?SentMessage
    {
        $email = MessageConverter::toEmail($message);
        
        $sendSmtpEmail = new SendSmtpEmail([
            'sender' => [
                'email' => $email->getFrom()[0]->getAddress(),
                'name' => $email->getFrom()[0]->getName() ?: 'PLV Cloud'
            ],
            'to' => array_map(function($address) {
                return [
                    'email' => $address->getAddress(),
                    'name' => $address->getName() ?: $address->getAddress()
                ];
            }, $email->getTo()),
            'subject' => $email->getSubject(),
            'htmlContent' => $email->getHtmlBody() ?: $email->getTextBody(),
            'textContent' => $email->getTextBody()
        ]);

        try {
            $result = $this->api->sendTransacEmail($sendSmtpEmail);
            \Log::info('Brevo API email sent', ['messageId' => $result->getMessageId()]);
            
            return new SentMessage($message, $envelope ?? \Symfony\Component\Mailer\Envelope::create($message));
        } catch (\Exception $e) {
            \Log::error('Brevo API error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function __toString(): string
    {
        return 'brevo-api';
    }
}
