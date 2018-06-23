<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Services\TypeService;

class TypeController extends Controller
{
    private $typeService;

    public function __construct(TypeService $typeService)
    {
        $this->typeService = $typeService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->typeService->list();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listActives()
    {
        return $this->typeService->listActives();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->typeService->findOne($id);
    }

}
