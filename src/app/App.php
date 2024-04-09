<?php

namespace App;

use App\DI\Container;
use App\DI\DatabaseService;
use App\DI\EmailService;
use App\DI\UserService;

class App
{
    private static DB $pdo;
    public function __construct(protected Router $router, protected array $request, protected Config $config)
    {
        static::$pdo = new DB($config->db ?? []);
    }

    public function run() : void
    {
        try {
            echo $this->router->resolve($this->request["uri"], strtolower($this->request["method"]));
        }catch (\Exception $ex)
        {
            header("HTTP/1.1 404 Not Found");
            echo View::make("error/404", []);
        }
    }

    public static function db() : DB
    {
        return static::$pdo;
    }
}