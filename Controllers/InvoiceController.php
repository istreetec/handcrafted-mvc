<?php
declare(strict_types=1);
namespace App\Controllers;

use App\View;
use App\Models\Invoice;

class InvoiceController
{
    public function index(): string
    {
        // Sessions once set, are available from any page
        // var_dump($_SESSION);

        // Specific session can be unset
        unset($_SESSION["count"]);


        // Delete cookies by setting the expiry time in the past
        setcookie(
            "username",
            "istreetec",

            // Note the substraction operator
            time() - 10,
        );

        return (string) View::make("invoices/index");
    }

    public function create(): string
    {
        return (string) View::make("invoices/create");
    }
    public function store(): void
    {
        // Initialize Models in the controller.
        $invoice = new Invoice();

        // Best practice;;
        // Form validations should be done in the controller.

        // Gets the amount from create() form.
        $amount = $_POST["amount"];

        // NB:: A controller prepares the data e.g. Validations, Slice, Encrypt
        // e.t.c then pass it into a Model.

        // e.g. Add $13.00 VAT to amount
        $totalAmount = (float) $amount + 13.00;
        
        $invoice->store($totalAmount);
    }
}
