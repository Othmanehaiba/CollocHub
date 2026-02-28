<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $users = User::latest()->get();

        $stats = [
            'users' => User::count(),
            'colocations' => Colocation::count(),
            'expenses' => Expense::count(),
            'banned' => User::where('is_banned', true)->count(),
        ];

        return view('admin.index', compact('users', 'stats'));
    }

    public function ban(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors([
                'admin' => 'Vous ne pouvez pas vous bannir vous-même.',
            ]);
        }

        $user->update([
            'is_banned' => true,
            'banned_at' => now(),
        ]);

        return back()->with('success', 'Utilisateur banni.');
    }

    public function unban(User $user): RedirectResponse
    {
        $user->update([
            'is_banned' => false,
            'banned_at' => null,
        ]);

        return back()->with('success', 'Utilisateur débanni.');
    }
}