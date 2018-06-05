<?php

namespace App\Services;
use \App\Repositories\OrderRepository;
use \App\Entities\Order;

class OrderService 
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function list()
    {
        $orders = $this->orderRepository->with(['items'])->paginate(10);
        foreach ($orders as $order) {
            $order->items->each(function($item){
                $item->product;
            });
            return $order;
        }
    }

    public function find($id)
    {
        $order = $this->orderRepository->with(['items'])->find($id);
            $order->items->each(function($item){
                $item->product;
            });
        return $order;
    }
}