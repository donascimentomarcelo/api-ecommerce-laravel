<?php

namespace App\Services;
use \App\Repositories\UserRepository;
use \App\Repositories\ClientRepository;
use \App\Entities\User;
use \App\Entities\Client;
use Aws\S3\S3Client;
use Aws\Credentials\Credentials;
use Aws\S3\Exception\S3Exception;

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

        $s3Client = $this->doConnectionWithAws();

        $image = $this->renameImage($request);

        try{    
            $result = $s3Client->putObject(array(
                'Bucket'     => 'eccomerceapp',
                'Key'        => $image['filenametostore'],
                'SourceFile' => $image['file_tmp'],
                'ACL'        => 'public-read'
            ));
        }catch(Exception $d){
            echo $e->getMessage();
        }
         
    }

    public function doConnectionWithAws()
    {
        $credentials = new Credentials(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));

        try {
            $s3Client = S3Client::factory(array(
                'credentials' => $credentials,
                'region' => 'sa-east-1',
                'version' => 'latest'
            ));
            return $s3Client;
        } catch (S3Exception $e) {
            return response()->json([
                'message' => 'A imagem não poderá ser alterada no momento! Tente mais tarde.',
            ],403);
            print_r($e->getMessage());
        }
    }

    public function renameImage($request)
    {
        $return['filename'] = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);

        $return['filenametostore'] = $return['filename'].'_'.time().'.'.$request->file('file')->getClientOriginalExtension();

        $return['file_tmp'] = $request->file('file')->getPathName();

        return $return;
    }
}