<?php

declare(strict_types=1);

namespace App\Service\Commission;

use App\Model\Operation;

abstract class WithdrawCommission implements CommissionCalculatorInterface
{
    abstract public function calculate(Operation $operation): string;
}
