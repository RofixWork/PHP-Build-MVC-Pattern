<?php

namespace App\Services;

class InvoiceService
{
    public function __construct(protected EmailService $emailService)
    {
    }

    public function manage(Customer $customer, string $message) : bool
    {

        echo $this->emailService->send($customer, $message);

        return true;
    }
}