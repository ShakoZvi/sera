<?php

declare(strict_types=1);

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Model\Operation;
use App\OperationProcessor;
use App\Service\Commission\DepositCommission;
use App\Service\Commission\PrivateWithdrawCommission;
use App\Service\Commission\BusinessWithdrawCommission;

class CommissionCalculatorTest extends TestCase
{
    public function testDepositCommission()
    {
        $operation = new Operation('2022-01-01', 'user1', 'private', 'deposit', 1000.00, 'EUR');
        $processor = new OperationProcessor();

        $commission = $processor->process($operation);

        $this->assertEquals('0.30', $commission);
    }

    public function testPrivateWithdrawCommission()
    {
        $operation = new Operation('2022-01-01', 'user1', 'private', 'withdraw', 1000.00, 'EUR');
        $processor = new OperationProcessor();

        $commission = $processor->process($operation);

        $this->assertEquals('3.00', $commission);
    }

    public function testBusinessWithdrawCommission()
    {
        $operation = new Operation('2022-01-01', 'user2', 'business', 'withdraw', 1000.00, 'EUR');
        $processor = new OperationProcessor();

        $commission = $processor->process($operation);

        $this->assertEquals('5.00', $commission);
    }
}
