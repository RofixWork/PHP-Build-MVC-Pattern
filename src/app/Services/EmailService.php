<?php
declare(strict_types=1);
namespace App\Services;

class EmailService
{
    public function send(Customer $customer, string $message) : string
    {
        sleep(3);
        return <<<EmailMessage
            Email: {$customer->getEmail()}
            Hello {$customer->getName()}
            Message:
            $message
EmailMessage;

    }
}