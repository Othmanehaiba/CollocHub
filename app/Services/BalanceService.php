<?php

namespace App\Services;

use App\Models\Colocation;

class BalanceService
{
    public function balances(Colocation $colocation): array
    {
        $memberships = $colocation->memberships()
            ->whereNull('left_at')
            ->with('user')
            ->get();

        $rows = [];

        foreach ($memberships as $membership) {
            $rows[$membership->user_id] = [
                'user' => $membership->user,
                'paid' => 0.0,
                'share' => 0.0,
                'balance' => 0.0,
            ];
        }

        $memberCount = count($rows);

        if ($memberCount === 0) {
            return $rows;
        }

        foreach ($colocation->expenses as $expense) {
            $share = (float) $expense->amount / $memberCount;

            foreach ($rows as &$row) {
                $row['share'] += $share;
            }

            if (isset($rows[$expense->paid_by])) {
                $rows[$expense->paid_by]['paid'] += (float) $expense->amount;
            }
        }

        foreach ($colocation->payments as $payment) {
            if (isset($rows[$payment->from_user_id])) {
                $rows[$payment->from_user_id]['paid'] += (float) $payment->amount;
            }

            if (isset($rows[$payment->to_user_id])) {
                $rows[$payment->to_user_id]['paid'] -= (float) $payment->amount;
            }
        }

        foreach ($rows as &$row) {
            $row['balance'] = round($row['paid'] - $row['share'], 2);
        }

        return $rows;
    }

    public function settlements(Colocation $colocation): array
    {
        $balances = $this->balances($colocation);

        $creditors = [];
        $debtors = [];

        foreach ($balances as $row) {
            if ($row['balance'] > 0.01) {
                $creditors[] = [
                    'user' => $row['user'],
                    'amount' => $row['balance'],
                ];  
            }

            if ($row['balance'] < -0.01) {
                $debtors[] = [
                    'user' => $row['user'],
                    'amount' => abs($row['balance']),
                ];
            }
        }

        $settlements = [];
        $i = 0;
        $j = 0;

        while ($i < count($debtors) && $j < count($creditors)) {
            $amount = min($debtors[$i]['amount'], $creditors[$j]['amount']);

            $settlements[] = [
                'from' => $debtors[$i]['user'],
                'to' => $creditors[$j]['user'],
                'amount' => round($amount, 2),
            ];

            $debtors[$i]['amount'] -= $amount;
            $creditors[$j]['amount'] -= $amount;

            if ($debtors[$i]['amount'] <= 0.01) {
                $i++;
            }

            if ($creditors[$j]['amount'] <= 0.01) {
                $j++;
            }
        }

        return $settlements;
    }

    public function userBalance(Colocation $colocation, int $userId): float
    {
        $balances = $this->balances($colocation);

        return $balances[$userId]['balance'] ?? 0.0;
    }
}