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

    public function completed(): Factory
    {
        return $this->state(function () {
            return [
                'status' => 1,
            ];
        });
    }
}
