<?php

namespace App\DI;

class UserService
{
    public function __construct(private EmailService $emailService, private DatabaseService $databaseService)
    {
        echo static::class;
    }

    public function register()
    {
        echo "register";
    }
}



