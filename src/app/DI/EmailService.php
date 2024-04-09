<?php

namespace App\DI;

class EmailService implements IEmailService
{
    public function __construct()
    {
        echo static::class . PHP_EOL;
    }

    public function sendEmail(): void
    {
        echo "email send...";
    }
}