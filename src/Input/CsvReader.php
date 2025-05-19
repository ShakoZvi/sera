<?php

namespace App\Input;

class CsvReader implements ReaderInterface
{
    public function read(string $filePath): array
    {
        $rows = [];
        $handle = fopen($filePath, 'r');
        if ($handle === false) {
            throw new \RuntimeException("Cannot open file: $filePath");
        }

        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            $rows[] = $data;
        }

        fclose($handle);
        return $rows;
    }
}
