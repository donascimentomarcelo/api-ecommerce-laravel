<?php

namespace App\Services;
use \App\Repositories\CategoryRepository;
use \App\Entities\Category;

class CategoryService 
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function list()
    {
        return $this->categoryRepository->paginate(5);
    }

    public function create($category)
    {
        return $this->categoryRepository->create($category);
    }

    public function update($category, $id)
    {
        return $this->categoryRepository->update($category, $id);
    }

    public function find($id)
    {
        $res = $this->categoryRepository->findByField('id', $id)->first();
        if(!$res)
        {
            return response()->json([
                'message' => 'A categoria de código '. $id .' não foi encontrada',
            ],404);
        }
        return $res;
    }

    public function findByName($name)
    {
        return $this->categoryRepository->findWhere(['name'=>['name', 'like', '%' . $name . '%']]);
    }
}