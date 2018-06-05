<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Services\ClientService;
use \App\Http\Requests\ClientRequest;
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

}
