<?php
declare(strict_types=1);
namespace App\Controllers;

use PDO;
use App\View;

class PDOController
{
    public function index(): string
    {
        // Tip:: To be secure throw an exception exposing lesser sensitive info
        try {
            $db = new PDO('mysql:host=127.0.0.1;dbname=my_db', 'root', 'password', [
                    // Change default fetch mode to PDO::FETCH_OBJ which will fetch each 
                    // row as an object of standard PHP class.
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,

                    // Prevent re-use of same parameter names.
                PDO::ATTR_EMULATE_PREPARES => false
            ]);

            $email = $_GET["email"] ?? "will@smith.com";
            $isActive = 1;

            // prepare statement's placeholders i.e. `?`
            // Best practice;;
            // use named parameters i.e. :paramname e.g. :email
            $query = 'SELECT * FROM users WHERE email= :email and is_active= :active';

            // Prepare Statement;;
            // returns PDOStatement object on which execute() can be invoked.
            $stat = $db->prepare($query);

            // Pass the actual values to replace placeholders.
            // Hint:: Use associative array for named parameters.
            // $stat->execute(["email" => $email]);

            // Tip:: You could also use an alternative to bind outside execute()
            // then later invoke execute().
            // 
            // bindValue(:paramName, paramValue, paramDataType). Default is PARAM_STR
            $stat->bindValue(":email", $email, PDO::PARAM_STR);

            // bindParam($args), similar to bindValue($args) rather it binds by reference thus 
            // uses the last updated value.
            $stat->bindParam(":active", $isActive, PDO::PARAM_BOOL);

            // Example;;
            // Updating $isActive = 0. bindParam() will use 0 as the value when binding.
            $isActive = 0;

            $stat->execute();

            foreach ($stat->fetchAll() as $user) {
                echo "<pre>";
                var_dump($user);
                echo "</pre>";
            }
        } catch (\PDOException $e) {
            // Pass the actual $message and $code when throwing into
            // PDOException constructor.
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
        var_dump($db);

        return (string) View::make("pdo/index");
    }
}



// P.S
// bindParam() and bindValue() are great with LOOPS when there are some common values
// which don't need to be changing inside the a loop.

// Solution :: bind common params outside the loop instead.

// PDO::ATTR_EMULATE_PREPARES => false
// Brings numerous advantages since it uses native prepares and skips casting
// ints, floats and booleans to strings.


// Best practice;;
// Prefer bindValue() to bindParam() for readability purposes.

