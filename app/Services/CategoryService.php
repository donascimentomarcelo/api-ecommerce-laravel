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
        return $this->categoryRepository->with(['types'])->paginate(5);
    }

    public function create($category)
    {
        $cat = $this->categoryRepository->create($category);

        $cat->types()->sync($this->getTypeIds($category['types']));

        return $cat;
    }

    public function update($category, $id)
    {
        $cat = $this->categoryRepository->update($category, $id);

        $cat->types()->sync($this->getTypeIds($category['types']));

        return $cat;
    }

    public function find($id)
    {
        $res = $this->categoryRepository->with(['types'])->findByField('id', $id)->first();
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
        return $this->categoryRepository->with(['types'])->findWhere(['name'=>['name', 'like', '%' . $name . '%']]);
    }

    public function getTypeIds($types)
    {
        $typesIds = [];

        foreach($types as $t)
        {
            $typesIds[] = $t['id'];
        }

        return $typesIds;
    }
}