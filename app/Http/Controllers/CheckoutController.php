<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Services\CheckoutService;
use App\Http\Requests\RequestCheckout;

class CheckoutController extends Controller
{
    private $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestCheckout $request)
    {
        return $this->checkoutService->create($request->all());
    }

}
