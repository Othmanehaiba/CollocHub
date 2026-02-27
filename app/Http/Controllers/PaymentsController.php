<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function store(Request $request, Colocation $colocation): RedirectResponse
    {
        $isMember = $colocation->memberships()
            ->where('user_id', auth()->id())
            ->whereNull('left_at')
            ->exists();

        if (! $isMember && ! auth()->user()->is_admin) {
            abort(403);
        }

        $memberIds = $colocation->memberships()
            ->whereNull('left_at')
            ->pluck('user_id')
            ->toArray();

        $validated = $request->validate([
            'to_user_id' => ['required', 'integer', 'in:' . implode(',', $memberIds)],
            'amount' => ['required', 'numeric', 'min:0.01'],
        ]);

        if ((int) $validated['to_user_id'] === auth()->id()) {
            return back()->withErrors([
                'payment' => 'Vous ne pouvez pas vous payer vous-même.',
            ]);
        }

        Payment::create([
            'colocation_id' => $colocation->id,
            'from_user_id' => auth()->id(),
            'to_user_id' => $validated['to_user_id'],
            'amount' => $validated['amount'],
            'note' => 'Paiement manuel',
        ]);

        return back()->with('success', 'Paiement enregistré.');
    }
}