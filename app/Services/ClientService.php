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

    public function find($id)
    {
        $data = $this->userRepository->with('client')->findByfield('id', $id);
        // $res = User::with('client')->find($id);
        $res = json_decode($data, true);
        if(empty($res))
        {
            return response()->json([
                'message' => 'O usuário de código '. $id .' não foi encontrado',
            ],404);
        }
        return $res;
    }

    public function findByName($name)
    {
        return $this->userRepository->with('client')->findWhere(['name'=>['name', 'like', '%' . $name . '%']]);
    }

    public function update($user, $id)
    {
        $user['password'] = bcrypt($user['password']);

        $userUpdated = $this->userRepository->with(['client'])->update($user, $id);
        
        $userUpdated['client'] = $this->clientRepository->update($user['client'], $userUpdated['client']['id']);
        
        return $userUpdated;
    }
}