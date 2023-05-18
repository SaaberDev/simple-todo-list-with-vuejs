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
        Item::factory()->count(13)->create();
        Item::factory()->count(4)->completed()->create();
        Item::factory()->count(5)->create();
    }
}
