<?php

namespace App\Controllers;


use App\DI\Container;
use App\DI\DatabaseService;
use App\DI\EmailService;
use App\DI\UserService;

class TestController
{
    public function __construct(private UserService $service)
    {

    }

    public function index()
    {
        $user = $this->service;
        $user->register();
        return "Test C";
    }
}