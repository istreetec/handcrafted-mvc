<?php
declare(strict_types=1);
namespace App\Models;

use PDO;
use App\Model;

class User extends Model
{
    public function create(string $email, string $name, bool $isActive = true): int
    {
        // Prepare Query 1 to register a user
        $stmt = $this->db->prepare(
            'INSERT INTO users (email, full_name, is_active, created_at)
                VALUES (:email, :fullname, 1, NOW())'
        );

        // Bind registered user query named params
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':fullname', $name, PDO::PARAM_STR);

        // Execute Query 1
        $stmt->execute();

        // Get new inserted record's id.
        // Tip :: Always invoke lastInsertId() before commit() rather the record 
        // will still reach database.
        return (int) $this->db->lastInsertId();
    }
}
