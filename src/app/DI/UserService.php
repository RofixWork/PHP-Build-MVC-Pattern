<?php

namespace App\DI;

class UserService
{
    public function __construct(private IEmailService $emailService, private DatabaseService $databaseService)
    {
        echo static::class;
    }

    public function register()
    {
        echo "register";
    }
}



