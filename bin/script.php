#!/usr/bin/env php
<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\App;

if ($argc < 2) {
    fwrite(STDERR, "Usage: php script.php <input_file.csv>\n");
    exit(1);
}

$inputFile = $argv[1];

if (!file_exists($inputFile)) {
    fwrite(STDERR, "Error: File not found - $inputFile\n");
    exit(1);
}

$app = new App();
// $app->run($inputFile);


$app->run($inputFile ?? 'input.csv');
