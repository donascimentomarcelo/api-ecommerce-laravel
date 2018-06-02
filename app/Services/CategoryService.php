<?php

namespace App\Services;
use \App\Repositories\CategoryRepository;

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
        return $this->categoryRepository->find($id);
    }
}