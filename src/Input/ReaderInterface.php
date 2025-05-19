<?php

namespace App\Input;

interface ReaderInterface
{
    public function read(string $filePath): array;
}
