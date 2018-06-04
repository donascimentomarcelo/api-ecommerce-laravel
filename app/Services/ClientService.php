<?php

namespace App\Services;
use \App\Repositories\ClientRepository;
use \App\Entities\Client;

class ClientService 
{
    private $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function list()
    {
        return $this->clientRepository->with(['user'])->paginate(10);
    }
}