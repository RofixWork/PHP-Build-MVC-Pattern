<?php

namespace App\DI;

interface IEmailService
{
    public function sendEmail() : void;
}