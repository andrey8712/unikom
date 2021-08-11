<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

class DeliveryController extends Controller
{

    public function index()
    {
        return view('delivery');
    }

    public function create()
    {
        return view('delivery.create');
    }

    public function update($id)
    {
        return view('delivery.update', ['updateId' => $id]);
    }

}