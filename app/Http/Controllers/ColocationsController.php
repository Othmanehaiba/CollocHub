<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\User;
use App\Services\BalanceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ColocationsController extends Controller
{
    public function index(): RedirectResponse
    {
        $membership = auth()->user()->activeMembership;

        if ($membership) {
            return redirect()->route('colocations.show', $membership->colocation_id);
        }

        return redirect()->route('colocations.create');
    }

    public function create(): View|RedirectResponse
    {
        if (auth()->user()->activeMembership) {
            return redirect()
                ->route('dashboard')
                ->withErrors(['colocation' => 'Vous avez déjà une colocation active.']);
        }

        return view('collocations.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if (auth()->user()->activeMembership) {
            return back()->withErrors(['colocation' => 'Vous avez déjà une colocation active.']);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $colocation = Colocation::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'status' => 'active',
            'owner_id' => auth()->id(),
        ]);

        Membership::create([
            'user_id' => auth()->id(),
            'colocation_id' => $colocation->id,
            'role' => 'owner',
            'joined_at' => now(),
        ]);

        return redirect()
            ->route('colocations.show', $colocation)
            ->with('success', 'Colocation créée avec succès.');
    }

    public function show(Colocation $colocation, Request $request, BalanceService $balanceService): View
    {
        $this->ensureMemberOrAdmin($colocation);

        $colocation->load([
            'owner',
            'memberships.user',
            'categories',
            'payments',
        ]);

        $expensesQuery = $colocation->expenses()
            ->with(['payer', 'category'])
            ->latest('expense_date');

        if ($request->filled('month')) {
            [$year, $month] = explode('-', $request->month);
            $expensesQuery
                ->whereYear('expense_date', $year)
                ->whereMonth('expense_date', $month);
        }

        $expenses = $expensesQuery->get();

        $availableMonths = $colocation->expenses()
            ->selectRaw("DATE_FORMAT(expense_date, '%Y-%m') as month_key")
            ->groupBy('month_key')
            ->pluck('month_key');

        $balances = $balanceService->balances(
            $colocation->load(['expenses', 'payments'])
        );

        $settlements = $balanceService->settlements($colocation);
        $myBalance = $balanceService->userBalance($colocation, auth()->id());

        return view('collocations.show', compact(
            'colocation',
            'expenses',
            'availableMonths',
            'balances',
            'settlements',
            'myBalance'
        ));
    }

    public function cancel(Colocation $colocation, BalanceService $balanceService): RedirectResponse
    {
        $this->ensureOwnerOrAdmin($colocation);

        $balances = $balanceService->balances(
            $colocation->load(['expenses', 'payments'])
        );

        foreach ($colocation->memberships()->whereNull('left_at')->get() as $membership) {
            $balance = $balances[$membership->user_id]['balance'] ?? 0;

            $membership->update([
                'left_at' => now(),
            ]);

            $membership->user->increment('reputation', $balance < -0.01 ? -1 : 1);
        }

        $colocation->update([
            'status' => 'cancelled',
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Colocation annulée.');
    }

    public function leave(Colocation $colocation, BalanceService $balanceService): RedirectResponse
    {
        $membership = $colocation->memberships()
            ->where('user_id', auth()->id())
            ->whereNull('left_at')
            ->firstOrFail();

        if ($membership->role === 'owner') {
            return back()->withErrors([
                'leave' => 'Le owner ne peut pas quitter la colocation.',
            ]);
        }

        $balance = $balanceService->userBalance(
            $colocation->load(['expenses', 'payments']),
            auth()->id()
        );

        if ($balance < -0.01) {
            Payment::create([
                'colocation_id' => $colocation->id,
                'from_user_id' => auth()->id(),
                'to_user_id' => $colocation->owner_id,
                'amount' => abs($balance),
                'note' => 'Départ avec dette transférée au owner',
            ]);

            auth()->user()->increment('reputation', -1);
        } else {
            auth()->user()->increment('reputation', 1);
        }

        $membership->update([
            'left_at' => now(),
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Vous avez quitté la colocation.');
    }

    public function removeMember(Colocation $colocation, User $user, BalanceService $balanceService): RedirectResponse
    {
        $this->ensureOwnerOrAdmin($colocation);

        $membership = $colocation->memberships()
            ->where('user_id', $user->id)
            ->whereNull('left_at')
            ->firstOrFail();

        if ($membership->role === 'owner') {
            return back()->withErrors([
                'remove' => 'Impossible de retirer le owner.',
            ]);
        }

        $balance = $balanceService->userBalance(
            $colocation->load(['expenses', 'payments']),
            $user->id
        );

        // if ($balance < -0.01) {
        //     Payment::create([
        //         'colocation_id' => $colocation->id,
        //         'from_user_id' => $user->id,
        //         'to_user_id' => $colocation->owner_id,
        //         'amount' => abs($balance),
        //         'note' => 'Retrait avec dette transférée au owner',
        //     ]);

        //     $user->increment('reputation', -1);
        // } else {
        //     $user->increment('reputation', 1);
        // }

        $membership->update([
            'left_at' => now(),
        ]);

        return back()->with('success', 'Membre retiré.');
    }


    private function ensureMemberOrAdmin(Colocation $colocation): void
    {
        $isMember = $colocation->memberships()
            ->where('user_id', auth()->id())
            ->exists();

        if (! $isMember && ! auth()->user()->is_admin) {
            abort(403);
        }
    }

    private function ensureOwnerOrAdmin(Colocation $colocation): void
    {
        $isOwner = $colocation->memberships()
            ->where('user_id', auth()->id())
            ->where('role', 'owner')
            ->whereNull('left_at')
            ->exists();

        if (! $isOwner && ! auth()->user()->is_admin) {
            abort(403);
        }
    }
}