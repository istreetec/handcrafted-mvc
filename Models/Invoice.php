<?php
declare(strict_types=1);
namespace App\Models;

use PDO;
use App\Model;

class Invoice extends Model
{
    public function create(float $amount, int $userId): int
    {
        // Prepare Query 2 to create a new invoice for that user
        $stmt = $this->db->prepare(
            'INSERT INTO invoices (amount, user_id)
                VALUES (:amount, :userid)'
        );

        // Execute Query 2 using Query 1 record's id as input
        $stmt->execute(["amount" => $amount, "userid" => $userId]);

        return (int) $this->db->lastInsertId();
    }

    public function find(int $id): array
    {
        $stmt = $this->db->prepare(
            'SELECT invoices.id AS invoice_id, amount, full_name
                FROM invoices
                LEFT JOIN users on users.id=user_id
                WHERE invoices.id= :invoiceid'
        );
        $stmt->execute(["invoiceid" => $id]);
        $invoice = $stmt->fetch(PDO::FETCH_ASSOC);

        return $invoice ? $invoice : [];
    }
}
