<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = [
            [
                'name' => 'Говяжья котлета',
                'kkal' => 100.2,
                'price' => 1,
            ],
            [
                'name' => 'Лист салата',
                'kkal' => 80.2,
                'price' => 1,
            ],
            [
                'name' => 'Бекон',
                'kkal' => 150.2,
                'price' => 1,
            ],
            [
                'name' => 'Ломтик сыра',
                'kkal' => 50.2,
                'price' => 1,
            ],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::query()->create($ingredient);
        }
    }
}
