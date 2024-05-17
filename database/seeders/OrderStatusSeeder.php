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
            [
                'name' => 'Заказ обрабатывается',
                'next_status_id' => '2,7',
            ],
            [
                'name' => 'Заказ принят',
                'next_status_id' => '3,7',
            ],
            [
                'name' => 'Заказ готовится',
                'next_status_id' => '4,7',
            ],
            [
                'name' => 'Заказ готов',
                'next_status_id' => '5,7',
            ],
            [
                'name' => 'Заказ в пути',
                'next_status_id' => '6',
            ],
            [
                'name' => 'Заказ получен',
                'next_status_id' => '',
            ],
            [
                'name' => 'Заказ отменен',
                'next_status_id' => '',
            ],
        ];

        foreach ($statuses as $status){
            OrderStatus::create($status);
        }
    }
}
