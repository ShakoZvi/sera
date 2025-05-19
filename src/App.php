<?php

declare(strict_types=1);

namespace App;

use App\Currency\CurrencyConverter;

class App
{
    public function run(string $filePath): void
    {
        echo "Processing file: {$filePath}\n";

        $currencyConverter = new CurrencyConverter();

        try {
            $currencyConverter->fetchRates();
            $rates = $currencyConverter->getRates();

            echo "Exchange rates (base: EUR):\n";
            if (is_array($rates)) {
                foreach ($rates as $currency => $rate) {
                    echo "{$currency}: {$rate}\n";
                }
            } else {
                echo "Unexpected data format for rates. Expected an array but got a scalar value.\n";
            }

        } catch (\Exception $e) {
            echo "Failed to fetch exchange rates: " . $e->getMessage() . "\n";
        }

        // აქ შეგიძლია შემდეგ დაამატო: operation parsing და CommissionCalculator-ის გამოძახება
    }
}
