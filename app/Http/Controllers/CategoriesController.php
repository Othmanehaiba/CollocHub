<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Colocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function store(Request $request, Colocation $colocation): RedirectResponse
    {
        $this->ensureOwnerOrAdmin($colocation);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        $name = trim($validated['name']);

        $exists = $colocation->categories()
            ->whereRaw('LOWER(name) = ?', [strtolower($name)])
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'category' => 'Cette catégorie existe déjà.',
            ]);
        }

        $colocation->categories()->create([
            'name' => $name,
        ]);

        return back()->with('success', 'Catégorie ajoutée.');
    }

    public function destroy(Colocation $colocation, Category $category): RedirectResponse
    {
        $this->ensureOwnerOrAdmin($colocation);

        if ($category->colocation_id !== $colocation->id) {
            abort(404);
        }

        if ($category->expenses()->exists()) {
            return back()->withErrors([
                'category' => 'Impossible de supprimer une catégorie déjà utilisée.',
            ]);
        }

        $category->delete();

        return back()->with('success', 'Catégorie supprimée.');
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