<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;
use App\Models\Membership;


class ColocationsController extends Controller
{
    public function store(Request $request) {

    if ($request->user()->activeMembership) {
        return back()->withErrors(['You already have an active colocation.']);
    }

    $colocation = Colocation::create([
        
    ]);

    Membership::create([
        'user_id' => auth()->id(),
        'colocation_id' => $colocation->id,
        'role' => 'owner',
        'joined_at' => now(),
    ]);
}
}
