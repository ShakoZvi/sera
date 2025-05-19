<?php

declare(strict_types=1);

namespace App;

use App\Model\Operation;
use App\Service\Commission\DepositCommission;
use App\Service\Commission\PrivateWithdrawCommission;
use App\Service\Commission\BusinessWithdrawCommission;
use App\Service\Commission\CommissionCalculatorInterface;
use App\Service\WeeklyWithdrawTracker;
use App\Currency\CurrencyConverter;

class OperationProcessor
{
    private WeeklyWithdrawTracker $tracker;
    private CurrencyConverter $converter;

    public function __construct(WeeklyWithdrawTracker $tracker, CurrencyConverter $converter)
    {
        $this->tracker = $tracker;
        $this->converter = $converter;
    }

    public function process(Operation $operation): string
    {
        $calculator = $this->resolveCalculator($operation);
        return $calculator->calculate($operation);
    }

    private function resolveCalculator(Operation $operation): CommissionCalculatorInterface
    {
        return match ([$operation->getType(), $operation->getUserType()]) {
            ['deposit', 'private'], ['deposit', 'business'] => new DepositCommission(),
            ['withdraw', 'business'] => new BusinessWithdrawCommission(),
            ['withdraw', 'private'] => new PrivateWithdrawCommission($this->tracker, $this->converter),
            default => throw new \RuntimeException("Unsupported operation type: {$operation->getType()} / {$operation->getUserType()}"),
        };
    }
}
