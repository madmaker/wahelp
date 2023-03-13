<?php
require __DIR__ . '/../src/UserList/Infrastructure/Service/ImportService.php';

use UserList\Infrastructure\Service\ImportService;

$ImportService = new ImportService();
$ImportService->processFiles();
