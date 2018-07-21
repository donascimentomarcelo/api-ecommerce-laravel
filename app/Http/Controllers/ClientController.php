<?php

namespace App\Http\Controllers;

use Aws\S3\S3Client;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use \App\Services\ClientService;
use Aws\Credentials\Credentials;
use Aws\S3\Exception\S3Exception;
use \App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\Storage;
use \App\Http\Requests\ClientUpdateRequest;

class ClientController extends Controller
{
    private $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }
    /**
     * Display a listing of the clients.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->clientService->list();
    }

    /**
     * Store a newly created client in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        return $this->clientService->create($request->all());
    }

    /**
     * Display the specified client.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->clientService->find($id);
    }

    /**
     * Display the specified client.
     *
     * @param string $name
     * @return void
     */
    public function findByName($name)
    {
        return $this->clientService->findByName($name);
    }

    /**
     * Check if email is able to be saved.
     *
     * @param string $email
     * @return void
     */
    public function findIfEmailExist($email)
    {
        return $this->clientService->checkIfEmailExist($email);
    }

    /**
     * Update the specified client in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientUpdateRequest $request, $id)
    {
        return $this->clientService->update($request->all(), $id);
    }

    public function sendPhoto(Request $request)
    {
        return $this->clientService->sendImageToAws($request);
    }

}
