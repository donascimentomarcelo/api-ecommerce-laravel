<?php

use Illuminate\Database\Seeder;
use \App\Entities\Order;
use \App\Entities\OrderItem;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Order::class, 10)->create()->each(function($order){
            for($i = 0; $i <= 5; $i ++)
            {
                $order->items()->save(factory(OrderItem::class)->make([
                    'product_id'=> rand(1, 110),
                    'qtd'      => rand(2,7),
                    'price'     => rand(50, 100)
                ]));
            }
        });
    }
}
