<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderType;

class OrderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $order_types = [
            [
                'name' => 'Погрузка/Разгрузка',
            ],
            [
                'name' => 'Такелажные работы',
            ],
            [
                'name' => 'Уборка',
            ],
        ];
        
        foreach($order_types as $item) {
            OrderType::firstOrCreate($item);
        }
    }
}
