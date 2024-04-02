<?php

namespace App\Controllers;



use App\View;

class InvoiceController
{
    public function index()
    {
//        $_SESSION["count"] = ($_SESSION["count"] ?? 0) + 1;
//        setcookie('user', 'ahmed', strtotime("-1 hour"));
//        setcookie('user', 'ahmed', time() + 10);
        return View::make("invoice/index", []);

    }

    public function create()
    {
        echo "<pre>";
        var_dump($_GET);
        var_dump($_POST);
        var_dump($_REQUEST);
        echo "</pre>";
        return View::make("invoice/create", []);
//super global = $_POST => return array ['amount' > 100]
    }

    public function store()
    {
        $amount = $_POST['amount'] ?? null;
        echo $amount;
    }

}