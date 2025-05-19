<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/EnvLoader.php';

use App\EnvLoader;
use App\OperationProcessor;
use App\Service\WeeklyWithdrawTracker;
use App\Currency\CurrencyConverter;
use App\Input\JsonLineReader;
use App\Input\CsvReader;
use App\Model\Operation;

// Load .env file
EnvLoader::load();

// Get input file
$inputFile = $argv[1] ?? __DIR__ . '/../test_operations.txt';

// Reader selection based on extension
$extension = pathinfo($inputFile, PATHINFO_EXTENSION);
$reader = $extension === 'csv' ? new CsvReader() : new JsonLineReader();

// Read and parse operations
$data = $reader->read($inputFile);

$tracker = new WeeklyWithdrawTracker();
$converter = new CurrencyConverter();
$converter->fetchRates();

$processor = new OperationProcessor($tracker, $converter);


foreach ($data as $row) {

    // echo "DEBUG RAW JSON: " . json_encode($row) . PHP_EOL;
    // echo "TYPE FIELD: " . $type . PHP_EOL;

    if ($extension === 'csv') {
        [$date, $userId, $userType, $type, $amount, $currency] = $row;
    } else {
        $date = $row['date'];
        $userId = (string)$row['user_id'];
        $userType = $row['user_type'];
        $type = $row['type'];
        $amount = $row['operation']['amount'];
        $currency = $row['operation']['currency'];

    }

    $operation = new Operation(
        $date,
        $userId,
        $userType,
        $type,
        (float)$amount,
        $currency
    );

    echo $processor->process($operation) . PHP_EOL;
}
