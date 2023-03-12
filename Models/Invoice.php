<?php
declare(strict_types=1);
namespace App\Models;

class Invoice
{
    public function __construct()
    {
        echo "Model initialized!" . "<br/>";
    }

    public function store(float $amount): void
    {
        echo "Amount {$amount} has been stored into Database";
    }
}
