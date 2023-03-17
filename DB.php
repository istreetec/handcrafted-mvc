<?php
declare(strict_types=1);
namespace App;

use PDO;

class DB
{
    private PDO $pdo;
    public function __construct(public array $config)
    {
        $defaultOptions = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false
        ];


        try {
            // initialize $db
            $this->pdo = new PDO(
                $config["driver"] .
                ':host=' . $config["host"] .
                ';dbname=' . $config["dbname"],
                $config["username"],
                $config["password"],
                $config["options"] ?? $defaultOptions,
            );
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    // Proxy PDO methods to be available on DB class passing in any arguments
    // Via __call()
    public function __call(string $name, array $arguments)
    {
        // Syntax:: 
        // call_user_func_array([new ClassName(), $methodName], $methodArguments)
        return call_user_func_array([$this->pdo, $name], $arguments);
    }
}
