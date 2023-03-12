<?php
declare(strict_types=1);
namespace App\Controllers;

use App\View;

class HomeController
{
    public function index(): string
    {
        // $_REQUEST;;
        // Contains payload from both $_GET and $_POST.
        // 
        // NB:: When $_GET and $_POST have a common property, the property
        // from the $_POST takes precedence and gets returned in the $_REQUEST.

        // $_REQUEST also contains cookies metadata


        // Store value in a session called count.
        // if count isn't set, set it to 0 and increment 1 anyways.

        // NB:: Sessions are stored as associative arrays
        $_SESSION["count"] = ($_SESSION["count"] ?? 0) + 1;


        // Store a cookie.
        // Tip::
        // Cookies also follow the sessions rule. i.e. can't initiated after
        // any output.
        setcookie(
            // cookie name
            "username",

            // cookie value
            "istreetec",

            // cookie expiry time
            // e.g. current time plus n number of seconds.
            // day = (24 * 60 * 60) i.e. Twenty Four Hours, Sixty Mins and Sixty Seconds
            time() + 10,

            // directory in which the cookie will be valid
            "/",

            // domain the cookie is available on
            "",

            // whether to send cookie via secure connection or not
            false,

            // whether to be accessible via http only 
            // if true client side can't access it e.g. JavaScript
            false
        );

        // Params are passed in the controller e.g. HomeController
        // comming from Models, $_GET, $_POST requests into a View
        // Then used in the view during rendering.
        return (string) View::make("index", ["name" => "Home"]);
    }

    public function prepareUploads(): string
    {
        // NB:: `FORM` is the heredoc identifier which could be anything of 
        // your choice.
        return (string) View::make("prepare-uploads", ["foo" => "bar"]);
    }

    // TP:: Never trust any user input comming from the super globals.
    // Always have a server validation in place
    public function upload(): void
    {
        // By default PHP uploaded files are stored in /tmp directory.
        // They can be moved to desired location afterwards
        $filePath = STORAGE_PATH . '/' . $_FILES["receipt"]["tmp_name"];
        // move_uploaded_file($_FILES["receipt"]["tmp_name"], $filePath);
        // var_dump(pathinfo($filePath));


        // Use location header to redirect the user to a new route once done
        // E.g. redirect them to home page
        header('Location: /');

        // Tip:: After redirecting. Always exit the script to avoid code 
        // below it executing since you have already redirected.
        exit;
    }


    public function download(): void
    {
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment;filename=myfile.pdf");
        readfile(STORAGE_PATH . '/receipt.pdf');
    }
}
