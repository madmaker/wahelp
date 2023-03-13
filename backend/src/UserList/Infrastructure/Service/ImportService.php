<?php
declare(strict_types=1);

namespace UserList\Infrastructure\Service;

require __DIR__.'/../Domain/ImportRepository.php';

use Exception;
use UserList\Infrastructure\Domain\ImportRepository;

class ImportService
{
    private ImportRepository $importService;

    public function __construct()
    {
        $this->importService = new ImportRepository();
    }

    private function handleFile(string $filename, int $importId): bool
    {
        $filePath = __DIR__ . '/../../../../uploads/' . $filename;

        if(!file_exists($filePath)) {
            $this->importService->updateFileImportStatus($importId, 'failed');
            return false;
        }

        $file = fopen($filePath, 'r');

        if ($file !== FALSE) {
            $this->importService->updateFileImportStatus($importId, 'in progress');

            $rowsTotal = 0;
            $rowsImported = 0;

            while (($data = fgetcsv($file, 100)) !== FALSE) {
                $rowsTotal++;
                for ($i = 0; $i < count($data); $i++) {
                    if (!isset($data[1]) || !is_numeric($data[0])) {
                        continue;
                    }

                    $number = $data[0];
                    $name = $data[1];
                    $this->importService->saveUser($number, $name, $importId);
                }
                $rowsImported++;
            }
            fclose($file);

            $this->importService->updateFileImportStatus($importId, 'done', $rowsTotal, $rowsImported);

            if ($rowsTotal !== $rowsImported) {
                unlink($filePath);
            }
            return true;
        } else {
            $this->importService->updateFileImportStatus($importId, 'failed');
            return false;
        }
    }

    public function processFiles(): void
    {
        $files = $this->importService->getFile();

        foreach ($files as $file) {
            $this->handleFile($file->filename, $file->id);
        }
    }
}