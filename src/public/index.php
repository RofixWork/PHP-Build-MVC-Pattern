<?php
require __DIR__ . "/../vendor/autoload.php";

$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
const STORAGE_PATH = __DIR__ . "/../storage";
const VIEW_PATH = __DIR__ . "/../views";

//session_start();
use App\Router;

//echo "<pre>";

$router = new Router();

$router->get("/", [App\Controllers\HomeController::class, "index"])
    ->post("/upload", [\App\Controllers\HomeController::class, "upload"])
    ->get('/invoice', [\App\Controllers\InvoiceController::class, 'index'])
    ->get('/invoice/create', [\App\Controllers\InvoiceController::class, 'create'])
    ->post('/invoice/store', [\App\Controllers\InvoiceController::class, 'store']);

(new \App\App($router, [
    "uri" => $_SERVER["REQUEST_URI"],
    "method" => $_SERVER["REQUEST_METHOD"],
], new \App\Config($_ENV)))->run();




