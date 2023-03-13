<?php
require __DIR__.'/../src/UserList/Controller/ImportController.php';

use UserList\Controller\ImportController;

$uri = $_SERVER['REQUEST_URI'];


if ($uri === '/userlist/upload') {
    $importController = new ImportController();
    $importController->uploadFile();
}