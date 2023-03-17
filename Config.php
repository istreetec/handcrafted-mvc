<?php
declare(strict_types=1);
namespace App;

class Config
{
    protected array $config;
    public function __construct(array $env)
    {
        $this->config = [
            "db" => [
                "driver" => $env[""] ?? "mysql",
                "host" => $env["DB_HOST"],
                "dbname" => $env["DB_NAME"],
                "username" => $env["DB_USERNAME"],
                "password" => $env["DB_PASSWORD"]
            ],

            "other" => [
                "name" => "blah blah..."
            ]
        ];
    }

    public function __get(string $name): ?array
    {
        return $this->config[$name] ?? null;
    }
}
