<?php
declare(strict_types=1);
namespace App\Controllers;

use PDO;
use App\View;

class PDOTransactionController
{
    public function index(): string
    {
        try {
            $db = new PDO(
                'mysql:host=' . $_ENV["DB_HOST"] . ';dbname=' . $_ENV["DB_NAME"],
                $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"],
                [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );

            // user input
            $email = "zonko@yahoo.com";
            $name = "Mutisya Nzonko";
            $amount = 243;

            // Try and catch any errors in order to rollback
            try {
                // --- BEGIN TRANSACTION
                $db->beginTransaction();

                // Prepare Query 1 to register a user
                $newUserRegStmt = $db->prepare(
                    'INSERT INTO users (email, full_name, is_active, created_at)
                VALUES (:email, :fullname, 1, NOW())'
                );

                // Prepare Query 2 to create a new invoice for that user
                $newInvoiceStmt = $db->prepare(
                    'INSERT INTO invoices (amount, user_id)
                VALUES (:amount, :userid)'
                );

                // Bind registered user query named params
                $newUserRegStmt->bindValue(':email', $email, PDO::PARAM_STR);
                $newUserRegStmt->bindValue(':fullname', $name, PDO::PARAM_STR);

                // Execute Query 1
                $newUserRegStmt->execute();

                // Get new inserted record's id.
                // Tip :: Always invoke lastInsertId() before commit() rather the record 
                // will still reach database.
                $userId = (int) $db->lastInsertId();

                // Execute Query 2 using Query 1 record's id as input
                $newInvoiceStmt->execute(["amount" => $amount, "userid" => $userId]);


                // Immediately the invoice is successfully created, commit.
                // 
                // --- COMMIT TRANSACTION
                $db->commit();

            } catch (\Throwable $e) {
                // Tip:: Always make sure to rollBack when an active transaction
                // is running.
                if ($db->inTransaction()) {
                    var_dump("--- rolling back");
                    $db->rollBack();
                }

                // NB:: You MUST rethrow the exception to exit.
                throw new \Exception($e->getMessage(), (int) $e->getCode());
            }

            // Query 3 to fetch the inserted user's invoice and display it/log
            // it into transaction_log table.
            $fetchStmt = $db->prepare(
                'SELECT invoices.id AS invoice_id, amount, user_id, full_name
                FROM invoices
                INNER JOIN users on user_id=users.id
                WHERE email= :useremail'
            );
            $fetchStmt->execute(["useremail" => $email]);


            // Render payload to UI
            echo "<pre>";
            var_dump($fetchStmt->fetch());
            echo "</pre>";

        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        return (string) View::make("pdo/transaction");
    }
}
