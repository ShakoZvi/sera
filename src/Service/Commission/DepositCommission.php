<?php

declare(strict_types=1);

namespace App\Service\Commission;

use App\Model\Operation;

class DepositCommission implements CommissionCalculatorInterface
{
    public function calculate(Operation $operation): string
    {
        $amount = $operation->getAmount();
        return bcmul((string) $amount, '0.0003', 2); // 0.03% commission
    }
}
