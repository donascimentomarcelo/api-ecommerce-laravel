<?php

namespace App\Services;
use Aws\S3\S3Client;
use \App\Entities\User;
use \App\Entities\Client;
use Tymon\JWTAuth\JWTAuth;
use Aws\Credentials\Credentials;
use Aws\S3\Exception\S3Exception;
use \App\Repositories\UserRepository;
use \App\Repositories\ClientRepository;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ClientService 
{
    private $userRepository;
    private $clientRepository;
    private $jWTAuth;

    public function __construct(
        UserRepository $userRepository, 
        ClientRepository $clientRepository,
        JWTAuth $jWTAuth)
    {
        $this->userRepository = $userRepository;
        $this->clientRepository = $clientRepository;
        $this->jWTAuth = $jWTAuth;
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
        $res = $this->userRepository->with('client')->findByfield('id', $id)->first();
        if(!$res)
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

    public function checkIfEmailExist($email)
    {
        $arr = $this->userRepository->findWhere(['email'=>['email', '=', $email ]])->first();
        
        if($arr)
        {
            $error['message'] = 'O e-mail '. $email .' ja está sendo utilizado';
            return response()->json([$error],422);
        }
    }

    public function sendImageToAws($request)
    {
        $image = $this->renameImage($request);
        
        $resizedImage = Image::make($request->file('file')->getRealPath())->resize(200, 200)->stream();

        Storage::disk('s3')->put($image['filenametostore'], $resizedImage->__toString() , 'public');
    }

    public function renameImage($request)
    {
        $id = $this->jWTAuth->parseToken()->authenticate()->id;

        $return['filenametostore'] = 'client'.$id.'.'.$request->file('file')->getClientOriginalExtension();

        return $return;
    }
}