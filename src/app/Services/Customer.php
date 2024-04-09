<?php

namespace App\Services;

class Customer
{
    public function __construct(private string $name, private string $email)
    {
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getEmail() : string
    {
        return $this->email;
    }
}