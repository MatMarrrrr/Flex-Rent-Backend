<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Listing;

class ListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam lectus risus, aliquam quis viverra eget, porta in ante. Maecenas vestibulum massa ligula, id mollis lorem ultrices et. Morbi non facilisis tortor. Nulla facilisi. Donec venenatis urna eget nisi sagittis suscipit. Suspendisse potenti. Integer gravida lorem sit amet semper placerat. Vivamus vitae tellus tempor, porta magna faucibus, luctus libero.";
        $listings = [
            [
                'owner_id' => 1,
                'category_id' => 1,
                'image' => 'https://i.imgur.com/UkehWwJ.png',
                'name' => "Ogłoszenie 1",
                'price' => "10",
                'currency' => "PLN",
                'localization' => "Miasto 1",
                'description' => $description,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'owner_id' => 1,
                'category_id' => 2,
                'image' => 'https://i.imgur.com/RwY4ieS.jpeg',
                'name' => "Ogłoszenie 2",
                'price' => "20",
                'currency' => "PLN",
                'localization' => "Miasto 2",
                'description' => $description,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'owner_id' => 1,
                'category_id' => 3,
                'image' => 'https://i.imgur.com/iPMFXGq.jpeg',
                'name' => "Ogłoszenie 3",
                'price' => "30",
                'currency' => "USD",
                'localization' => "Miasto 3",
                'description' => $description,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($listings as $listing) {
            Listing::create($listing);
        }
    }
}
