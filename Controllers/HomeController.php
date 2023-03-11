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

        return (string) View::make("index");
    }

    public function prepareUploads(): string
    {
        // NB:: `FORM` is the heredoc identifier which could be anything of 
        // your choice.
        return <<<FORM
        <form action="/upload" method="post" enctype="multipart/form-data">
            <input type="file" name="receipt" id="receipt" />
            <button type="submit">Upload</button>
        </form>
        FORM;
    }

    // TP:: Never trust any user input comming from the super globals.
    // Always have a server validation in place
    public function upload(): void
    {
        echo "<pre>";
        var_dump($_FILES);
        echo "</pre>";

        // By default PHP uploaded files are store in /tmp directory.
        // They can be moved to desired location afterwards
        $filePath = STORAGE_PATH . '/' . $_FILES["receipt"]["tmp_name"];
        move_uploaded_file($_FILES["receipt"]["tmp_name"], $filePath);

        echo "<pre>";
        var_dump(pathinfo($filePath));
        echo "</pre>";
    }
}
