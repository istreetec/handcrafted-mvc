<?php
declare(strict_types=1);
namespace App;

use App\Exceptions\RouteNotFoundException;

class App
{
    private static DB $db;
    public function __construct(
        protected Router $router,
        protected array $request,
        protected Config $config
    )
    {
        // This database instance and connection is to be shared accross the app
        try {
            // initialize $db
            static::$db = new DB($config->db ?? []);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    // Expose private $db
    public static function db(): DB
    {
        return static::$db;
    }

    public function run(): void
    {
        try {
            // Tip:: Don't depend on superglobals within classes 
            // e.g. $_SERVER and $_ENV instead have them passed into 
            // App via driver file i.e. index.php
            echo $this->router->resolve(
                $this->request['uri'],
                strtolower($this->request['method'])
            );
        } catch (RouteNotFoundException) {
            http_response_code(404);
            echo (string) View::make("error/404");
        }
    }
}
