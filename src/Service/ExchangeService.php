<?php

namespace App\Service;

class ExchangeService
{
    public function convertToEur(float $amount, string $currency): float
    {
        // დროებითი კურსები მხოლოდ ტესტისთვის
        $rates = [
            'EUR' => 1.0,
            'USD' => 1.1,
            'JPY' => 129.53
        ];

        if (!isset($rates[$currency])) {
            throw new \Exception("Unsupported currency: $currency");
        }

        return round($amount / $rates[$currency], 2);
    }
}
