<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'Ogłoszenia', 'description' => 'Aktualności i informacje ze świata strzelectwa.']);
        Category::create(['name' => 'Sprzęt', 'description' => 'Dyskusje o wyposażeniu i sprzęcie.']);
        Category::create(['name' => 'Strzelnice', 'description' => 'Informacje o strzelnicach w Twojej okolicy.']);
    }
}
