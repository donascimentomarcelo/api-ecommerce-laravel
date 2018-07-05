<?php

namespace App\Services;
use \App\Entities\Product;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\DB;
use \App\Repositories\ProductRepository;

class ProductService 
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function list()
    {
        return $this->productRepository->with(['category'])->paginate(10);
    }

    public function create($product)
    {
        \DB::beginTransaction();
        try{
            $prod = $this->productRepository->create($product);
            
            $result = $this->find($prod->id);

            \DB::commit();

            return $result;
        }catch(\Exception $e)
        {
            \DB::rollback();
            throw $e;
        }
    }

    public function find($id)
    {
        $res = $this->productRepository->with(['category'])->findByField('id', $id)->first();
        if(!$res)
        {
            return response()->json([
                'message' => 'O produto de código '. $id .' não foi encontrado',
            ],404);
        }
        return $res;
    }

    public function update($product, $id)
    {
      \DB::beginTransaction();
      try{
        $prod = $this->productRepository->update($product, $id);

        $result = $this->find($prod->id);
        
        \DB::commit();
        
        return $result;
      } 
      catch(\Exception $e)
      {
        \DB::rollback();
        throw $e;
      } 
      
    }

    public function findByName($name)
    {
        return $this->productRepository->with(['category'])->findWhere(['name'=> ['name', 'like', '%' . $name . '%']]);
    }

    public function findByCategory($idCategory)
    {
        return $this->productRepository->findWhere(['category_id' => ['category_id', 'like', '%' .$idCategory. '%']]);
    }
}