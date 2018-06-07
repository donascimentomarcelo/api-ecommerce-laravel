<?php

namespace App\Services;
use \App\Repositories\CupomRepository;
use \App\Entities\Cupom;

class CupomService 
{
    private $cupomRepository;

    public function __construct(CupomRepository $cupomRepository)
    {
        $this->cupomRepository = $cupomRepository;
    }

    public function list()
    {
        return $this->cupomRepository->paginate(10);
    }

    public function find($id)
    {
        $res = $this->cupomRepository->findByField('id', $id)->first();
        if(!$res)
        {
            return response()->json([
                'message' => 'O cupom de código '. $id .' não foi encontrado',
            ],404);
        }
        return $res;
    }

    public function create($cupom)
    {
        $cupom['code'] = $this->generateCode();
        return $this->cupomRepository->create($cupom);
    }

    public function generateCode()
    {
        $now = strtotime("now");
        $dateFaker = strtotime("now") + rand(1,9999);

        return rand($now, $dateFaker);
    }
}