<?php

namespace App\Services;
use \App\Repositories\UserRepository;
use \App\Repositories\ClientRepository;
use \App\Entities\User;
use \App\Entities\Client;

class ClientService 
{
    private $userRepository;
    private $clientRepository;

    public function __construct(UserRepository $userRepository, ClientRepository $clientRepository)
    {
        $this->userRepository = $userRepository;
        $this->clientRepository = $clientRepository;
    }

    public function list()
    {
        return $this->userRepository->with(['client'])->paginate(10);
    }
}