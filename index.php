<?php
declare(strict_types=1);
namespace App;

use App\Exceptions\RouteNotFoundException;
use App\Controllers\{HomeController, InvoiceController};

// Super Globals Usage;;
// - Access to input from user forms
// - Persist Sessions and work with Cookies
// - Upload Files
// - Look into requests 
// - e.t.c
require_once __DIR__ . '/vendor/autoload.php';

// NB:: Sessions must be started before any output.
// Best practice;;  
// place them at the start of driver file i.e. program entry point e.g. index.php

// Start the session
session_start();


// Define constant to storage directory path.
// Tip:: This constant will be available in all class files too
define("STORAGE_PATH", __DIR__ . "/storage");
define("VIEW_PATH", __DIR__ . "/Views");

$route = new Router();


try {
    // Register Routes
    $route->get("/", [HomeController::class, "index"])
        ->get("/upload", [HomeController::class, "prepareUploads"])
        ->get("/download", [HomeController::class, "download"])
        ->post("/upload", [HomeController::class, "upload"])
        ->get("/invoices", [InvoiceController::class, "index"])
        ->get("/invoices/create", [InvoiceController::class, "create"])
        ->post("/invoices/create", [InvoiceController::class, "store"]);

    echo $route->resolve(
        $_SERVER['REQUEST_URI'],
        strtolower($_SERVER['REQUEST_METHOD']) // e.g. get and post
    );
} catch (RouteNotFoundException $e) {
    // NB:: HTTP Headers e.g. status codes should be send before any output
    http_response_code(404);

    echo (string) View::make("error/404");
}


// Cookies;;
// - Stored on the client side on the user's computer.
// - Only get distroyed after their expiration date

// Sessions;;
// - Stored on the server
// - Destroyed as soon as the browser is closed

// Access all stored sessions
// var_dump($_SESSION);


// Access all stored cookies
// var_dump($_COOKIE);


// P.S
// - If you delete the PHPSESSID cookie, 
// all the sessions will be reset.

