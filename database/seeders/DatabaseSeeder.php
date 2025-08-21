<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Add a few items
        Item::create(["name"=>"Cobblestone", "game_id"=>"minecraft_cobblestone", "count"=>"100000", "for_sale"=>"50000"]);
        Item::create(["name"=>"Iron Ingot", "game_id"=>"minecraft_iron_ingot", "count"=>"40000", "for_sale"=>"7000"]);
        Item::create(["name"=>"Deepslate", "game_id"=>"minecraft_deepslate", "count"=>"10000", "for_sale"=>"0"]);
        Item::create(["name"=>"Oak Log", "game_id"=>"minecraft_oak_log", "count"=>"10000", "for_sale"=>"0"]);
        Item::create(["name"=>"Firework Rocket", "game_id"=>"minecraft_firework_rocket", "count"=>"53704", "for_sale"=>"53704"]);
    }
}
