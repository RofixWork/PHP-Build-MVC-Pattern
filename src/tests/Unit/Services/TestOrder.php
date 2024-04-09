<?php
declare(strict_types=1);
namespace Tests\Unit\Services;

use App\Services\OrderManager;
use App\Services\PaypalPayment;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class TestOrder extends TestCase
{
    /**
     * @throws Exception
     */
    public function testProcessPaymentInOrderManager()
    {
        $payment = $this->createMock(PaypalPayment::class);
        $payment->expects($this->once())
            ->method("processPayment")
            ->willReturn(false);
        $orderManager = new OrderManager($payment);

        $status = $orderManager->processPayment();

        $this->assertTrue($status, "Payment Failed");


    }
}