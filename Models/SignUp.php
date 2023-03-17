<?php
declare(strict_types=1);
namespace App\Models;

use App\Model;

class SignUp extends Model
{
    public function __construct(
        protected User $userModel,
        protected Invoice $invoiceModel
    )
    {
        // Invoke parent constructor to have access to $this->db
        parent::__construct();
    }

    public function register(array $userInfo, array $invoiceInfo): int
    {
        // Try and catch any errors in order to rollback
        try {
            // --- BEGIN TRANSACTION --- 
            $this->db->beginTransaction();

            $userId = $this->userModel->create($userInfo["email"], $userInfo["name"]);
            $invoiceId = $this->invoiceModel->create($invoiceInfo["amount"], $userId);

            // --- COMMIT TRANSACTION --- 
            $this->db->commit();
        } catch (\Throwable $e) {
            // Tip:: Always make sure to rollBack when an active transaction
            // is running.
            if ($this->db->inTransaction()) {
                var_dump("--- rolling back");
                $this->db->rollBack();
            }

            // NB:: You MUST rethrow the exception to exit.
            throw new \Exception($e->getMessage(), (int) $e->getCode());
        }

        return $invoiceId;
    }
}
