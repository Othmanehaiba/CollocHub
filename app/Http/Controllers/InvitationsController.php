<?php

namespace App\Http\Controllers;

use App\Mail\InvitationMail;
use App\Models\Colocation;
use App\Models\Invitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InvitationsController extends Controller
{
    public function store(Request $request, Colocation $colocation): RedirectResponse
    {
        $isOwner = $colocation->memberships()
            ->where('user_id', auth()->id())
            ->where('role', 'owner')
            ->whereNull('left_at')
            ->exists();

        if (! $isOwner && ! auth()->user()->is_admin) {
            abort(403);
        }

        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $alreadyPending = $colocation->invitations()
            ->where('email', $validated['email'])
            ->where('status', 'pending')
            ->exists();

        if ($alreadyPending) {
            return back()->withErrors([
                'invitation' => 'Une invitation en attente existe déjà pour cet email.',
            ]);
        }

        $token = Str::random(32);

        Invitation::create([
            'colocation_id' => $colocation->id,
            'email' => $validated['email'],
            'token' => $token,
            'status' => 'pending',
            'expires_at' => now()->addDays(7),
        ]);

        Mail::to($validated['email'])->send(
            new InvitationMail($colocation, $token)
        );

        return back()->with('success', 'Invitation envoyée.');
    }
}