<?php

namespace App\Services;

interface IPayment
{
    public function processPayment(): bool;
}