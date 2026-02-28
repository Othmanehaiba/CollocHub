<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'owner_id',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function activeMembers()
    {
        return $this->hasMany(Membership::class)->whereNull('left_at');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}