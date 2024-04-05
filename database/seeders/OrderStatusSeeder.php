<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'Заказ обрабатывается',
            'Заказ принят',
            'Заказ готовится',
            'Заказ готов',
            'Заказ в пути',
            'Заказ получен'
        ];

        foreach ($statuses as $status){
            OrderStatus::create([
                'name' => $status
            ]);
        }
    }
}
