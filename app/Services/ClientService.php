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

    public function create($user)
    {
        $user['password'] = bcrypt($user['password']);

        $userSaved = $this->userRepository->create($user);
        
        $user['client']['user_id'] = $userSaved['id'];

        $userSaved['client'] = $this->clientRepository->create($user['client']);

        return $userSaved;
    }
}