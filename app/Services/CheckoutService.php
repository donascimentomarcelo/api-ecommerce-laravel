<?php

namespace App\Services;
use \App\Repositories\OrderRepository;
use \App\Repositories\CupomRepository;
use \App\Repositories\ProductRepository;
use \App\Entities\Order;
use \App\Entities\Cupom;
use \App\Entities\Product;
use \Illuminate\Support\Facades\DB;
use \League\Flysystem\Exception;

class CheckoutService
{
    private $orderRepository;
    private $cupomRepository;
    private $productRepository;

    public function __construct(
        OrderRepository $orderRepository,  
        CupomRepository $cupomRepository, 
        ProductRepository $productRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->cupomRepository = $cupomRepository;
        $this->productRepository = $productRepository;
    }

    public function create($data)
    {
        \DB::beginTransaction();
        try{
            $data['status'] = 0;
    
            if(isset($data['cupom_code']))
            {
                $cupom = $this->cupomRepository->findByField('code', $data['cupom_code'])->first();
                $data['cupom'] = $cupom->id;
                $cupom->used = 1;
                $cupom->save();
                unset($data['cupom_code']);
            }
    
            $items = $data['items'];
            unset($data['items']);
    
            $order = $this->orderRepository->create($data);
            $total = 0;
    
            foreach($items as $item)
            {
                $items['price'] = $this->productRepository->find($item['product_id'])->price;
                $order->items()->create($item);
                $total += $item['price'] * $item['qtd'];
            }
    
            $order->total = $total;
            if(isset($cupom))
            {
                $order->total = $total - $cupom->value;
            }
            $order->save();
            \DB::commit();
            
            return $order;
        }catch(\Exception $e){
            \DB::rollback();
            throw $e;
        }
    }
}