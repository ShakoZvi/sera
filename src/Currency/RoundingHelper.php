<?php

declare(strict_types=1);

namespace App\Currency;

class RoundingHelper
{
    public function round(float $amount, int $decimals): float
    {
        return round($amount, $decimals);
    }
}
