<?php

declare(strict_types=1);

namespace App\Service\Commission;

use App\Model\Operation;

class BusinessWithdrawCommission extends WithdrawCommission
{
    public function calculate(Operation $operation): string
    {
        $amount = $operation->getAmount();
        $commissionRate = '0.005'; // 0.5%
        return bcmul((string) $amount, $commissionRate, 2);
    }
}
