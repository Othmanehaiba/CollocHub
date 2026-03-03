<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpensesController extends Controller
{
    public function index(Colocation $colocation): RedirectResponse
    {
        return redirect()->route('colocations.show', $colocation);
    }

    public function create(Colocation $colocation): View
    {
        $this->ensureActiveMember($colocation);

        $members = $colocation->memberships()
            ->whereNull('left_at')
            ->with('user')
            ->get();

        $categories = $colocation->categories()->orderBy('name')->get();

        return view('expenses.create', compact('colocation', 'members', 'categories'));
    }

    public function store(Request $request, Colocation $colocation): RedirectResponse
    {
        $this->ensureActiveMember($colocation);

        $memberIds = $colocation->memberships()
            ->whereNull('left_at')
            ->pluck('user_id')
            ->toArray();

        $categoryIds = $colocation->categories()
            ->pluck('id')
            ->toArray();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer', 'in:' . implode(',', $categoryIds)],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'expense_date' => ['required', 'date'],
            
        ]);

        Expense::create([
            'colocation_id' => $colocation->id,
            'paid_by' => auth()->id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'amount' => $validated['amount'],
            'expense_date' => $validated['expense_date'],
        ]);

        return redirect()
            ->route('colocations.show', $colocation)
            ->with('success', 'Dépense ajoutée.');
    }

    private function ensureActiveMember(Colocation $colocation): void
    {
        $isMember = $colocation->memberships()
            ->where('user_id', auth()->id())
            ->whereNull('left_at')
            ->exists();

        if (! $isMember && ! auth()->user()->is_admin) {
            abort(403);
        }
    }
}