<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductIngredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Бургеры'
            ],
            [
                'name' => 'Твистеры'
            ],
            [
                'name' => 'Супы'
            ],
        ];
        $products = [
            [
                'name' => 'Бургер от Дани',
                'description' => 'Фирменный бургер кафе "Сытый Даня". 2 шрипролла в кунжунтой булочке с соусом Кам.',
                'price' => 100,
                'category_id' => 1,
                'kkal' => 10.2,
                'photo' => '/products/1/img.png',
            ],
            [
                'name' => 'Твистер от Дани',
                'description' => 'Фирменный твистер кафе "Сытый Даня". 2 шрипролла в абхазском лаваше с соусом 300Бакс.',
                'price' => 1000,
                'category_id' => 2,
                'kkal' => 10.2,
                'photo' => '/products/2/img.png',
            ],
            [
                'name' => 'Рамен от Дани',
                'description' => 'Фирменный рамен кафе "Сытый Даня". Наруто отдыхает.',
                'price' => 1000,
                'category_id' => 3,
                'kkal' => 10.2,
                'photo' => '/products/3/img.png',
            ],
        ];
        $ingredients = [
            [
                'ingredient_id' => 1,
                'product_id' => 1,
                'count' => 1,
            ],
            [
                'ingredient_id' => 2,
                'product_id' => 1,
                'count' => 1,
            ],
            [
                'ingredient_id' => 1,
                'product_id' => 2,
                'count' => 1,
            ],
            [
                'ingredient_id' => 2,
                'product_id' => 2,
                'count' => 1,
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::query()->create($category);
        }
        foreach ($products as $product) {
            Product::query()->create($product);
        }
        foreach ($ingredients as $ingredient) {
            ProductIngredient::query()->create($ingredient);
        }
    }
}
