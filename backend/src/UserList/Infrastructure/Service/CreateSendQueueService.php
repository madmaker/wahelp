<?php

namespace UserList\Infrastructure\Service;

require __DIR__ . '/../Domain/SendRepository.php';

use UserList\Infrastructure\Domain\SendRepository;

class CreateSendQueueService
{
    private SendRepository $sendService;

    public function __construct()
    {
        $this->sendService = new SendRepository();
    }

    public function createSendQueue(string $title, string $text): void
    {
        $mailingId = (int)$this->sendService->createMailing($title, $text);

        $users = $this->sendService->getUsers();

        foreach ($users as $user) {
            $this->sendService->addUserToSendQueue($user->id, $mailingId);
        }
    }
}