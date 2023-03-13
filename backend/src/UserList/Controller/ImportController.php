<?php
declare(strict_types=1);

namespace UserList\Controller;

require __DIR__.'/../Infrastructure/Domain/ImportRepository.php';

use UserList\Infrastructure\Domain\ImportRepository;

class ImportController
{
    private ImportRepository $importService;

    public function __construct() {
        $this->importService=new ImportRepository();
    }
    //route: userlist/upload
    public function uploadFile(): void
    {
        if (!isset($_FILES['file'])) {
            http_response_code(204);
            exit();
        }

        $targetDir = __DIR__ . "/../../../uploads/";
        $targetFileName = basename(substr($_FILES["file"]["name"], 0, 200) . time());
        $targetFile = $targetDir . $targetFileName;

        $this->importService->saveFileToDB($targetFileName);

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            http_response_code(202);
        } else {
            http_response_code(500);
        }
    }
}