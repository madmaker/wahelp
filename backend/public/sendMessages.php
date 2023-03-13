<?php
require __DIR__ . '/../src/UserList/Infrastructure/Service/SendMessagesService.php';

use UserList\Infrastructure\Service\SendMessagesService;

$sendMessagesService = new SendMessagesService();
$sendMessagesService->sendMessages();
