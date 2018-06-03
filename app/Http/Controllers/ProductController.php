<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Requests\ProductRequest;
use \App\Services\ProductService;

class ProductController extends Controller
{
    private $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->productService->list();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        return $this->productService->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->productService->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        return $this->productService->update($request->all(), $id);
    }

    /**
     * Display the specified resource by name.
     *
     * @param  int  $name
     * @return \Illuminate\Http\Response
     */
    public function findByName($name)
    {
        return $this->productService->findByName($name);
    }

    /**
     * Display all products relationship with idCategory
     *
     * @param int $idCategory
     * @return \Illuminate\Http\Response
     */
    public function findByCategory($idCategory)
    {
        return $this->productService->findByCategory($idCategory);
    }
}
