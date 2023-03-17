<?php
declare(strict_types=1);
namespace App;

use App\Controllers\{
    HomeController,
    InvoiceController,
    PDOController,
    PDOTransactionController
};

require_once __DIR__ . '/vendor/autoload.php';

// Load .env file's environmental variables
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

define("STORAGE_PATH", __DIR__ . "/storage");
define("VIEW_PATH", __DIR__ . "/Views");

$router = new Router();

// Register Routes
$router->get("/", [HomeController::class, "index"])
    ->get("/upload", [HomeController::class, "prepareUploads"])
    ->get("/download", [HomeController::class, "download"])
    ->get("/pdo", [PDOController::class, "index"])
    ->get("/pdo/transaction", [PDOTransactionController::class, "index"])
    ->post("/upload", [HomeController::class, "upload"])
    ->get("/invoices", [InvoiceController::class, "index"])
    ->get("/invoices/create", [InvoiceController::class, "create"])
    ->post("/invoices/create", [InvoiceController::class, "store"]);

$app = new App(
    $router,
    [
        "uri" => $_SERVER["REQUEST_URI"],
        "method" => $_SERVER["REQUEST_METHOD"]
    ],
    new Config($_ENV)
);

// Start the Application
$app->run();
