<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\OperationProcessor;
use App\Service\ExchangeService;

class CommissionCalculatorTest extends TestCase
{
    private OperationProcessor $processor;

    protected function setUp(): void
    {
        $exchangeService = new ExchangeService(); // ეს შენს ლოგიკას შეესაბამება
        $this->processor = new OperationProcessor($exchangeService, 'EUR');
    }

    public function testDepositCommission(): void
    {
        $operation = [
            'date' => '2025-01-01',
            'user_id' => 1,
            'user_type' => 'private',
            'type' => 'deposit',
            'operation' => [
                'amount' => 200.00,
                'currency' => 'EUR'
            ]
        ];

        $result = $this->processor->calculate($operation);
        $this->assertEquals('0.06', $result); // assuming 0.03% deposit fee
    }

    public function testPrivateWithdrawCommission(): void
    {
        $operation = [
            'date' => '2025-01-02',
            'user_id' => 1,
            'user_type' => 'private',
            'type' => 'withdraw',
            'operation' => [
                'amount' => 1200.00,
                'currency' => 'EUR'
            ]
        ];

        $result = $this->processor->calculate($operation);
        $this->assertEquals('0.60', $result); // assuming free limit exceeded
    }

    public function testBusinessWithdrawCommission(): void
    {
        $operation = [
            'date' => '2025-01-03',
            'user_id' => 2,
            'user_type' => 'business',
            'type' => 'withdraw',
            'operation' => [
                'amount' => 1000.00,
                'currency' => 'EUR'
            ]
        ];

        $result = $this->processor->calculate($operation);
        $this->assertEquals('5.00', $result); // assuming 0.5% fee
    }
}
