<?php
declare(strict_types=1);
namespace App\Controllers;

use App\View;
use App\Models\{User, Invoice, SignUp};

class PDOTransactionController
{
    public function index(): string
    {
        // user input
        $email = "kiptanuie@yahoo.com";
        $name = "Kipkoech Kevin";
        $amount = 300;

        // Access Models
        $userModel = new User();
        $invoiceModel = new Invoice();

        $invoiceId = (new SignUp($userModel, $invoiceModel))->register(
            [
                "email" => $email,
                "name" => $name
            ],
            [
                "amount" => $amount
            ]
        );


        return (string) View::make(
            "pdo/transaction",
            ["invoice" => $invoiceModel->find($invoiceId)]
        );
    }
}
