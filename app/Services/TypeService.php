<?php

namespace App\Services;

use App\Repositories\TypeRepository;

Class TypeService
{
    private $typeRepository;

    public function __construct(TypeRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }

    public function list()
    {
        return $this->typeRepository->all();
    }

    public function listActives()
    {
        return $this->typeRepository->findWhere(['status' => ['status', '=', 1]]);
    }

    public function findOne($id)
    {
        return $this->typeRepository->find($id);
    }
}