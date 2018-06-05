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
        return $this->orderRepository->with(['items'])->paginate(10);
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