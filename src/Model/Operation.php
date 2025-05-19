<?php

declare(strict_types=1);

namespace App\Model;

class Operation
{
    private $date;
    private $userId;
    private $userType;
    private $type;
    private $amount;
    private $currency;

    public function __construct(
        string $date,
        string $userId,
        string $userType,
        string $type,
        float $amount,
        string $currency
    ) {
        $this->date = $date;
        $this->userId = $userId;
        $this->userType = $userType;
        $this->type = $type;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getDate(): string
    {
        return $this->date;
    }
    
    public function getUserId(): int
    {
        return (int)$this->userId;
    }
    
    public function getUserType(): string
    {
        return $this->userType;
    }
    
    public function getType(): string
    {
        return $this->type;
    }
    
    public function getAmount(): float
    {
        return $this->amount;
    }
    
    public function getCurrency(): string
    {
        return $this->currency;
    }
    

}
