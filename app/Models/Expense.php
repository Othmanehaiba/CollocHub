<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'colocation_id',
        'paid_by',
        'category_id',
        'title',
        'amount',
        'expense_date',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'expense_date' => 'date',
        ];
    }

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}