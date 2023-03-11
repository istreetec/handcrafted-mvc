<?php
declare(strict_types=1);
namespace App\Controllers;

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

        return 'Invoices';
    }
    public function create(): string
    {
        return <<<HTML
        <form action="/invoices/create" method="post">
        <label for="amount">Amount</label>
        <input type="number" name="amount" id="amount" />
        </form>
        HTML;
    }
    public function store(): void
    {
        // Gets the amount from create() form and displays it.
        $amount = $_POST["amount"];
        var_dump($amount);
    }
}
