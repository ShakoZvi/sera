<?php

declare(strict_types=1);

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/EnvLoader.php';

use App\EnvLoader;
use App\OperationProcessor;
use App\Service\WeeklyWithdrawTracker;
use App\Currency\CurrencyConverter;
use App\Input\CsvReader;
use App\Input\JsonLineReader;
use App\Model\Operation;

EnvLoader::load();

// ✅ სწორი ფაილის გზა
$inputFile = __DIR__ . '/test_operations.txt'; // ან input.csv

// Auto detect reader
$extension = pathinfo($inputFile, PATHINFO_EXTENSION);
$reader = $extension === 'csv' ? new CsvReader() : new JsonLineReader();

$data = $reader->read($inputFile);

$tracker = new WeeklyWithdrawTracker();
$converter = new CurrencyConverter();

try {
    $converter->fetchRates();
} catch (Exception $e) {
    echo "<strong>⚠ ვალუტის კურსების ჩატვირთვა ვერ მოხერხდა:</strong><br>" . $e->getMessage();
    $converter->setRates([
        'EUR' => 1.0,
        'USD' => 1.1497,
        'JPY' => 129.53
    ]);
}

$processor = new OperationProcessor($tracker, $converter);

echo "<pre>";
foreach ($data as $row) {
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

    // ✅ Debug გამოსახვა ბრაუზერში
    echo "<strong>DEBUG</strong> → type: <code>" . htmlspecialchars($type) . "</code> | user_type: <code>" . htmlspecialchars($userType) . "</code><br>";

    $operation = new Operation($date, $userId, $userType, $type, (float)$amount, $currency);
    echo $processor->process($operation) . "\n";
}
echo "</pre>";
