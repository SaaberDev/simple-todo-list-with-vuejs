<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::factory()->count(25)->create();
        Item::factory()->count(20)->completedAt()->create();
        Item::factory()->count(5)->deletedAt()->create();
    }
}
