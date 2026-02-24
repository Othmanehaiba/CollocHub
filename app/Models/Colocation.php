<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    public function users()
{
    return $this->belongsToMany(User::class)
        ->withPivot('role','joined_at','left_at');
}
}
