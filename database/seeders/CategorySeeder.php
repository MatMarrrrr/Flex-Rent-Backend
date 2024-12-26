<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $icons = [
            "https://i.imgur.com/CM1lFgb.png",
            "https://i.imgur.com/dxpotXg.png",
            "https://i.imgur.com/jTMni7I.png",
            "https://i.imgur.com/UNlfZIT.png",
            "https://i.imgur.com/BGyRjjr.png",
            "https://i.imgur.com/JrqFMPE.png",
            "https://i.imgur.com/QOPYJim.png",
            "https://i.imgur.com/PUddQiT.png",
            "https://i.imgur.com/WMVMe3e.png",
            "https://i.imgur.com/8OdwDMK.png",
        ];

        foreach ($icons as $icon) {
            Category::create(['icon' => $icon]);
        }
    }
}
