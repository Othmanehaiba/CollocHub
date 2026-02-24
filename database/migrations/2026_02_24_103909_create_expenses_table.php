<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('colocation_id')->constrained()->onDelete('cascade');
            $table->foreignId('paid_by')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->date('expense_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};