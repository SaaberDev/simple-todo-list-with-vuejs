<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'user_id' => 1
        ];
    }

    public function completedAt(): Factory
    {
        return $this->state(function () {
            return [
                'completed_at' => now(),
            ];
        });
    }

    public function deletedAt(): Factory
    {
        return $this->state(function () {
            return [
                'deleted_at' => now(),
            ];
        });
    }
}
