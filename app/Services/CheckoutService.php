<?php

namespace App\Services;
use \App\Entities\Cupom;
use \App\Entities\Order;
use \App\Entities\Product;
use Tymon\JWTAuth\JWTAuth;
use \League\Flysystem\Exception;
use \Illuminate\Support\Facades\DB;
use \App\Repositories\CupomRepository;
use \App\Repositories\OrderRepository;
use \App\Repositories\ProductRepository;

class CheckoutService
{
    private $orderRepository;
    private $cupomRepository;
    private $productRepository;
    private $jWTAuth;

    public function __construct(
        OrderRepository $orderRepository,  
        CupomRepository $cupomRepository, 
        ProductRepository $productRepository,
        JWTAuth $jWTAuth)
    {
        $this->orderRepository = $orderRepository;
        $this->cupomRepository = $cupomRepository;
        $this->productRepository = $productRepository;
        $this->jWTAuth = $jWTAuth;
    }

    public function create($data)
    {
        \DB::beginTransaction();
        try{
            $data['user_id'] = $this->jWTAuth->parseToken()->authenticate()->id;
            $data['status'] = 0;
    
            if(isset($data['cupom_code']))
            {
                $cupom = $this->cupomRepository->findByfield('code', $data['cupom_code'])->first();
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