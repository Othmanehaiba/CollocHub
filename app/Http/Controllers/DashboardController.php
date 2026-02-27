<?php

namespace App\Http\Controllers;

use App\Services\BalanceService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(BalanceService $balanceService): View
    {
        $membership = auth()->user()
            ->activeMembership()
            ->with('colocation')
            ->first();

        $colocation = null;
        $monthlyTotal = 0;
        $recentExpenses = collect();
        $members = collect();
        $categories = collect();
        $settlements = [];
        $myBalance = 0;

        if ($membership && $membership->colocation) {
            $colocation = $membership->colocation->load([
                'categories',
                'memberships.user',
                'expenses.payer',
                'expenses.category',
                'payments',
            ]);

            $monthlyTotal = (float) $colocation->expenses()
                ->whereYear('expense_date', now()->year)
                ->whereMonth('expense_date', now()->month)
                ->sum('amount');

            $recentExpenses = $colocation->expenses()
                ->with(['payer', 'category'])
                ->latest('expense_date')
                ->take(5)
                ->get();

            $members = $colocation->memberships
                ->where('left_at', null);

            $categories = $colocation->categories;

            $myBalance = $balanceService->userBalance($colocation, auth()->id());
            $settlements = $balanceService->settlements($colocation);
        }

        return view('dashboard', compact(
            'colocation',
            'monthlyTotal',
            'recentExpenses',
            'members',
            'categories',
            'settlements',
            'myBalance'
        ));
    }
}