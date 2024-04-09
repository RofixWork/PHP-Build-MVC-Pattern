<?php
declare(strict_types=1);
namespace App\Services;

class OrderManager
{
    public function __construct(protected IPayment $payment)
    {
    }

    public function processPayment() : bool
    {
        $status = $this->payment->processPayment();

        if(!$status)
        {
            return false;
        }

        return  true;
    }
}
