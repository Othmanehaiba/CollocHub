<?php

namespace Database\Factories;

use App\Models\Colocation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Colocation>
 */
class ColocationsFactory extends Factory
{
    protected $model = Colocation::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company().' Coloc',
            'description' => fake()->sentence(),
            'status' => 'active',
            'owner_id' => User::factory(),
        ];
    }
}