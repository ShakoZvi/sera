<?php

declare(strict_types=1);

namespace App\Service\Commission;

use App\Model\Operation;

interface CommissionCalculatorInterface
{
    public function calculate(Operation $operation): string;
}
