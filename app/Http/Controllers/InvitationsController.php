<?php

namespace App\Http\Controllers;

use App\Mail\InvitationMail;
use App\Models\Colocation;
use App\Models\Invitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Membership;
use Illuminate\View\View;

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

     public function open(string $token): RedirectResponse
    {
        $invitation = $this->getValidInvitation($token);

        // If already logged in, go directly to accept/refuse page
        if (auth()->check()) {
            return redirect()->route('invitations.respond', $invitation->token);
        }

        // Check if account already exists with invited email
        $userExists = User::where('email', $invitation->email)->exists();

        if ($userExists) {
            // Save token in session, so after login we can continue the invitation flow
            session(['invite_token' => $invitation->token]);

            return redirect()
                ->route('login')
                ->with('status', 'Connectez-vous pour répondre à votre invitation.');
        }

        // No account yet -> keep your current register flow
        return redirect()->route('register', ['invite' => $invitation->token]);
    }

    // NEW: page where logged user can accept or refuse
    public function respond(string $token): View|RedirectResponse
    {
        $invitation = $this->getValidInvitation($token);

        $redirect = $this->checkInvitationAccess($invitation);
        if ($redirect) {
            return $redirect;
        }

        $alreadyMember = Membership::where('user_id', auth()->id())
            ->where('colocation_id', $invitation->colocation_id)
            ->whereNull('left_at')
            ->exists();

        if ($alreadyMember) {
            $invitation->update([
                'status' => 'accepted',
            ]);

            return redirect()
                ->route('colocations.show', $invitation->colocation_id)
                ->with('success', 'Vous faites déjà partie de cette colocation.');
        }

        return view('invitations.respond', compact('invitation'));
    }

    // NEW: accept invitation
    public function accept(string $token): RedirectResponse
    {
        $invitation = $this->getValidInvitation($token);

        $redirect = $this->checkInvitationAccess($invitation);
        if ($redirect) {
            return $redirect;
        }

        $alreadyMember = Membership::where('user_id', auth()->id())
            ->where('colocation_id', $invitation->colocation_id)
            ->whereNull('left_at')
            ->exists();

        if (! $alreadyMember) {
            Membership::create([
                'user_id' => auth()->id(),
                'colocation_id' => $invitation->colocation_id,
                'role' => 'member',
                'joined_at' => now(),
            ]);
        }

        $invitation->update([
            'status' => 'accepted',
        ]);

        return redirect()
            ->route('colocations.show', $invitation->colocation_id)
            ->with('success', 'Invitation acceptée. Bienvenue dans la colocation.');
    }

    // NEW: refuse invitation
    public function refuse(string $token): RedirectResponse
    {
        $invitation = $this->getValidInvitation($token);

        $redirect = $this->checkInvitationAccess($invitation);
        if ($redirect) {
            return $redirect;
        }

        $invitation->update([
            'status' => 'refused',
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Invitation refusée.');
    }

    private function getValidInvitation(string $token): Invitation
    {
        $invitation = Invitation::where('token', $token)
            ->where('status', 'pending')
            ->firstOrFail();

        if ($invitation->expires_at && now()->greaterThan($invitation->expires_at)) {
            abort(403, 'Invitation expirée.');
        }

        return $invitation;
    }

    private function checkInvitationAccess(Invitation $invitation): ?RedirectResponse
    {
        // Logged user email must match invited email
        if (strtolower(auth()->user()->email) !== strtolower($invitation->email)) {
            return redirect()
                ->route('dashboard')
                ->withErrors([
                    'invitation' => 'Cette invitation ne correspond pas à votre email.',
                ]);
        }

        // Your project logic: one active colocation at a time
        $activeMembership = auth()->user()->activeMembership;

        if ($activeMembership && $activeMembership->colocation_id !== $invitation->colocation_id) {
            return redirect()
                ->route('dashboard')
                ->withErrors([
                    'invitation' => 'Vous avez déjà une colocation active.',
                ]);
        }

        return null;
    }
}