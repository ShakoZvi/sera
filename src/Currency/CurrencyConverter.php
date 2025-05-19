<?php

namespace App\Currency;

class CurrencyConverter
{
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = getenv('CURRENCY_API_KEY') ?: '';
        // $this->apiKey = "4fJmIJi0OVl7xNOiHdZce1zdfjEvMJP1";

        if (empty($this->apiKey)) {
            throw new \RuntimeException('API key not set in environment.');
        }
    }
    private const BASE_CURRENCY = 'EUR';
    private const API_URL = 'https://api.apilayer.com/exchangerates_data/latest';

    private array $rates = [];

    public function fetchRates(): void
    {
        $url = self::API_URL . '?base=' . self::BASE_CURRENCY;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "apikey: " . $this->apiKey,
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \RuntimeException('CURL Error: ' . curl_error($ch));
        }

        curl_close($ch);

        $data = json_decode($response, true);
        if (!isset($data['rates'])) {
            throw new \RuntimeException("Invalid response from currency API: $response");
        }

        $this->rates = $data['rates'];
    }

    public function getRate(string $currency): float
    {
        if ($currency === self::BASE_CURRENCY) {
            return 1.0;
        }

        return $this->rates[$currency] ?? throw new \InvalidArgumentException("Rate for $currency not found.");
    }

    public function getRates(): array
    {
        return $this->rates;
        // $this->rates = [
        //     'EUR' => 1.0,
        //     'USD' => 1.1497,
        //     'JPY' => 129.53
        // ];

    }
}
