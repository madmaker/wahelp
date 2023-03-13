<?php
declare(strict_types=1);

namespace UserList\Infrastructure\Domain;

require __DIR__ . '/../../../Common/DB.php';

use Common\DB;
use PDO;

class SendRepository
{
    private PDO $db;
    private $mailing;

    public function __construct()
    {
        $this->db = DB::db();
    }

    public function addUserToSendQueue($userId, $mailingId): void
    {
        $sql = "INSERT INTO send_queue (user_id,mailing_id) VALUES (:user_id,:mailing_id)";

        $statement = $this->db->prepare($sql);

        $statement->execute([
            ':user_id' => $userId,
            ':mailing_id' => $mailingId,
        ]);
    }

    public function createMailing(string $title, string $text): bool|string
    {
        $sql = "INSERT INTO mailings (title,text) VALUES (:title, :text)";

        $statement = $this->db->prepare($sql);

        $statement->execute([
            ':title' => $title,
            ':text' => $text
        ]);
        return $this->db->lastInsertId();
    }

    public function getUsers(): bool|array
    {
        $sql = "SELECT id FROM users";

        $statement = $this->db->prepare($sql);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function getRecipients(): bool|array
    {
        $sql = "SELECT send_queue.id as id, mailing_id, number, name 
        FROM send_queue
        JOIN users u on send_queue.user_id = u.id
        WHERE status='new'
        ";

        $statement = $this->db->prepare($sql);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function getMailing(int $mailingId)
    {
        if (!isset($this->mailing[$mailingId])) {

            $sql = "SELECT title, text, id 
            FROM mailings
            WHERE id=:id
            ";

            $statement = $this->db->prepare($sql);

            $statement->execute([
                ':id' => $mailingId
            ]);

            $this->mailing[$mailingId] = $statement->fetchObject();
        }
        return $this->mailing[$mailingId];
    }

    public function updateRecipientStatus(int $id, string $status): void
    {
        $sql = "UPDATE send_queue 
        SET status=:status
        WHERE id=:id";

        $statement = $this->db->prepare($sql);

        $statement->execute([
            ':status' => $status,
            ':id' => $id,
        ]);
    }
}