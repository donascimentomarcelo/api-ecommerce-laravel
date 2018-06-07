<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Services\CupomService;
use \App\Http\Requests\CupomRequest;

class CupomController extends Controller
{
    private $cupomService;

    public function __construct(CupomService $cupomService)
    {
        $this->cupomService = $cupomService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->cupomService->list();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CupomRequest $request)
    {
        return $this->cupomService->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->cupomService->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

}
