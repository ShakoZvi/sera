<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Operation;

class WeeklyWithdrawTracker
{
    private array $userOperations = [];

    public function add(Operation $operation): void
    {
        $userId = $operation->getUserId();
        $week = $this->getWeekId($operation->getDate());

        if (!isset($this->userOperations[$userId][$week])) {
            $this->userOperations[$userId][$week] = [];
        }

        $this->userOperations[$userId][$week][] = $operation;
    }

    public function getWithdrawalsThisWeek(int $userId, string $date): array
    {
        $week = $this->getWeekId($date);
        return $this->userOperations[$userId][$week] ?? [];
    }

    private function getWeekId(string $date): string
    {
        $dt = new \DateTime($date);
        return $dt->format("o-W");
    }

    public function getWeeklyWithdrawStats(int $userId, string $date): array
    {
        $operations = $this->getWithdrawalsThisWeek($userId, $date);

        $totalAmount = 0.0;
        $count = 0;

        foreach ($operations as $op) {
            if ($op->getType() === 'withdraw' && $op->getUserType() === 'private') {
                $totalAmount += $op->getAmount();
                $count++;
            }
        }

        return [
            'count' => $count,
            'total' => $totalAmount,
        ];
    }
    
}
