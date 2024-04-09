<?php

namespace App\Services;

class PaypalPayment implements IPayment
{

    public function processPayment(): bool
    {
        sleep(3);
        $paymentStatus = rand(0, 1);

        return (bool)$paymentStatus;
    }
}