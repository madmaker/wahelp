<?php
declare(strict_types=1);

namespace UserList\Infrastructure\Domain;

require __DIR__.'/../../../Common/DB.php';

use Common\DB;
use PDO;

class ImportRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DB::db();
    }

    public function saveFileToDB($filename): void
    {
        $sql = "INSERT INTO uploaded_files_queue (filename) VALUES (:filename)";

        $statement = $this->db->prepare($sql);

        $statement->execute([
            ':filename' => $filename
        ]);
    }

    public function getFile(): bool|array
    {
        $sql = "SELECT id, filename FROM uploaded_files_queue WHERE status='new' FOR UPDATE LIMIT 1";

        $statement = $this->db->prepare($sql);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateFileImportStatus(int $importId, string $status, int $rowsTotal=0, int $rowsImported=0): void
    {
        $sql = "UPDATE uploaded_files_queue SET 
        status=:status, 
        rows_total=:rows_total, 
        rows_imported=:rows_imported 
        WHERE id=:id";

        $statement = $this->db->prepare($sql);

        $statement->execute([
            ':status' => $status,
            ':id' => $importId,
            ':rows_total' => $rowsTotal,
            ':rows_imported' => $rowsImported,
        ]);
    }

    public function saveUser(string $number, string $name, int $importId): void
    {
        $sql = "INSERT INTO users (number, name, import_id)
        VALUES(:number,:name,:import_id) 
        ON CONFLICT (number) 
        DO 
        UPDATE SET name = :name, import_id=:import_id";

        $statement = $this->db->prepare($sql);

        $statement->execute([
            ':number' => $number,
            ':name' => $name,
            ':import_id' => $importId,
        ]);
    }
}