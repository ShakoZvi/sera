<?php

declare(strict_types=1);

namespace App;

/**
 * Class EnvLoader
 * 
 * Loads environment variables from a .env file using putenv().
 */
class EnvLoader
{
    /**
     * Load environment variables from the given file path.
     *
     * @param string $filePath Path to the .env file (default is project root)
     * @return void
     */
    public static function load(string $filePath = __DIR__ . '/../.env'): void
    {
        if (!file_exists($filePath)) {
            return;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            // Ignore empty lines and comments
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            if (!str_contains($line, '=')) {
                continue;
            }

            [$name, $value] = explode('=', $line, 2);
            putenv(trim($name) . '=' . trim($value));
        }
    }
}
