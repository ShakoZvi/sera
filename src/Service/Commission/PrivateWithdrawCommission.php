<?php

declare(strict_types=1);

namespace App\Service\Commission;

use App\Model\Operation;
use App\Service\WeeklyWithdrawTracker;
use App\Currency\CurrencyConverter;

class PrivateWithdrawCommission extends WithdrawCommission
{
    private WeeklyWithdrawTracker $tracker;
    private CurrencyConverter $converter;

    public function __construct(WeeklyWithdrawTracker $tracker, CurrencyConverter $converter)
    {
        $this->tracker = $tracker;
        $this->converter = $converter;
    }

    public function calculate(Operation $operation): string
    {
        $userId = $operation->getUserId();
        $date = $operation->getDate();

        $this->tracker->add($operation);
        $stats = $this->tracker->getWeeklyWithdrawStats($userId, $date);

        $commissionRate = '0.003';
        $freeLimit = 1000.00;
        $freeOps = 3;

        $amountEUR = $operation->getCurrency() === 'EUR'
            ? $operation->getAmount()
            : $operation->getAmount() / $this->converter->getRate($operation->getCurrency());

        $commissionable = $amountEUR;

        if ($stats['count'] <= $freeOps && $stats['total'] <= $freeLimit) {
            $remaining = $freeLimit - $stats['total'];
            if ($remaining >= $amountEUR) {
                return '0.00';
            } else {
                $commissionable = $amountEUR - $remaining;
            }
        }

        return bcmul((string) $commissionable, $commissionRate, 2);
    }
}
