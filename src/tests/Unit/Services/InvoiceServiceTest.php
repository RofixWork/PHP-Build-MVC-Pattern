<?php

namespace Tests\Unit\Services;

use App\Services\Customer;
use App\Services\EmailService;
use App\Services\InvoiceService;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class InvoiceServiceTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testManageInvoice()
    {
        $em = $this->createMock(EmailService::class);

        $inv = new InvoiceService($em);

        $result = $inv->manage(new Customer("ahmed", "email"), "Hello Ahmed how are you?");

        var_dump($result);

        $this->assertTrue($result);

    }
}