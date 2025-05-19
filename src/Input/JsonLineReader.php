<?php

namespace App\Input;

class JsonLineReader implements ReaderInterface
{
    public function read(string $filePath): array
    {
        $rows = [];
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $decoded = json_decode($line, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $rows[] = $decoded;
            } else {
                throw new \RuntimeException("Invalid JSON line: $line");
            }
        }

        return $rows;
    }
}
