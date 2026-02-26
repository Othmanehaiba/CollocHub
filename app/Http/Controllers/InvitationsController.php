<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvitationsController extends Controller
{
    public function store(){
        $token = Str::random(32);
        Invitation::create([
            'colocation_id' => $colocation->id,
            'email' => $request->email,
            'token' => $token,
            'expires_at' => now()->addDays(7),
        ]);
        // Send email with link: route('invitations.accept', $token)
        Mail::to($request->email)->send(new InvitationMail($colocation, $token));
    }
}
