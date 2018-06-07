<?php

namespace App\Services;
use \App\Repositories\ProductRepository;
use \App\Entities\Product;

class ProductService 
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function list()
    {
        return $this->productRepository->paginate(10);
    }

    public function create($product)
    {
        return $this->productRepository->create($product);
    }

    public function find($id)
    {
        $res = $this->productRepository->findByField('id', $id)->first();
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
        return $this->productRepository->update($product, $id);
    }

    public function findByName($name)
    {
        return $this->productRepository->findWhere(['name'=> ['name', 'like', '%' . $name . '%']]);
    }

    public function findByCategory($idCategory)
    {
        return $this->productRepository->findWhere(['category_id' => ['category_id', 'like', '%' .$idCategory. '%']]);
    }
}