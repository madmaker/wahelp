<?php

namespace UserList\Infrastructure\Service;

require __DIR__ . '/../Domain/SendRepository.php';

use UserList\Infrastructure\Domain\SendRepository;

class SendMessagesService
{
    private SendRepository $sendRepository;

    public function __construct()
    {
        $this->sendRepository = new SendRepository();
    }

    private function send(string $name, string $number, string $title, string $text): void
    {
        echo $name;
        echo "\n";
        echo $number;
        echo "\n";
        echo $title;
        echo "\n";
        echo $text;
        echo "\n";
        echo "\n";
    }

    public function sendMessages(): void
    {
        $recipients = $this->sendRepository->getRecipients();

        foreach ($recipients as $recipient) {
            if($mailing=$this->sendRepository->getMailing((int)$recipient->mailing_id)) {
                $this->send($recipient->name, $recipient->number, $mailing->title, $mailing->text);

                $this->sendRepository->updateRecipientStatus($recipient->id, 'sent');
            }
        }

    }
}