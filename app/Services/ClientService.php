<?php

namespace App\Services;
use Aws\S3\S3Client;
use \App\Entities\User;
use \App\Entities\Client;
use Tymon\JWTAuth\JWTAuth;
use App\Services\ImageService;
use League\Flysystem\Exception;
use Aws\Credentials\Credentials;
use Aws\S3\Exception\S3Exception;
use Illuminate\Support\Facades\DB;
use \App\Repositories\UserRepository;
use \App\Repositories\ClientRepository;
use Illuminate\Support\Facades\Storage;

class ClientService 
{
    private $userRepository;
    private $clientRepository;
    private $jWTAuth;
    private $imageService;
    public static $width = 200;
    public static $height = 200;

    public function __construct(
        UserRepository $userRepository, 
        ClientRepository $clientRepository,
        JWTAuth $jWTAuth,
        ImageService $imageService)
    {
        $this->userRepository = $userRepository;
        $this->clientRepository = $clientRepository;
        $this->jWTAuth = $jWTAuth;
        $this->imageService = $imageService;
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
        DB::beginTransaction();
        try{
            $userUpdated = $this->userRepository->with(['client'])->find($id);

            $userUpdated->name  = $user['name'];
            $userUpdated->email = $user['email'];
            $userUpdated->save();
            
            $userUpdated['client'] = $this->clientRepository->update($user['client'], $userUpdated['client']['id']);
            
            DB::commit();

            return $userUpdated;
        }catch(Exception $e){
            DB::rollback();
            return $e->getMessage();
        }
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
        
        $resizedImage = $this->imageService->resizeImage($request, self::$width, self::$height);

        Storage::disk('s3')->put($image['filenametostore'], $resizedImage->__toString() , 'public');
    }

    public function renameImage($request)
    {
        $id = $this->jWTAuth->parseToken()->authenticate()->id;

        $return['filenametostore'] = 'client'.$id.'.'.$request->file('file')->getClientOriginalExtension();

        return $return;
    }
}