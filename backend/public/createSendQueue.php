<?php
require __DIR__ . '/../src/UserList/Infrastructure/Service/CreateSendQueueService.php';

use UserList\Infrastructure\Service\CreateSendQueueService;

$createSendQueueService = new CreateSendQueueService();

$title = "Тестовая рассылка";
$text = "Тестовое сообщение";

$createSendQueueService->createSendQueue($title, $text);
