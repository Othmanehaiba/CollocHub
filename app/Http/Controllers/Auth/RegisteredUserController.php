<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(Request $request): View
    {
        $invitation = null;

        if ($request->filled('invite')) {
            $invitation = Invitation::where('token', $request->invite)
                ->where('status', 'pending')
                ->first();

            if ($invitation && $invitation->expires_at && now()->greaterThan($invitation->expires_at)) {
                $invitation = null;
            }
        }

        return view('auth.register', compact('invitation'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'invite_token' => ['nullable', 'string'],
        ]);

        $invitation = null;

        if ($request->filled('invite_token')) {
            $invitation = Invitation::where('token', $request->invite_token)
                ->where('status', 'pending')
                ->first();

            if (! $invitation) {
                return back()->withErrors([
                    'invite_token' => 'Invitation invalide.',
                ])->withInput();
            }

            if ($invitation->expires_at && now()->greaterThan($invitation->expires_at)) {
                return back()->withErrors([
                    'invite_token' => 'Invitation expirée.',
                ])->withInput();
            }

            if (strtolower($request->email) !== strtolower($invitation->email)) {
                return back()->withErrors([
                    'email' => 'Cet email doit correspondre à l’email invité.',
                ])->withInput();
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (User::count() === 1) {
            $user->update([
                'is_admin' => true,
            ]);
        }

        if ($invitation) {
            Membership::create([
                'user_id' => $user->id,
                'colocation_id' => $invitation->colocation_id,
                'role' => 'member',
                'joined_at' => now(),
            ]);

            $invitation->update([
                'status' => 'accepted',
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}