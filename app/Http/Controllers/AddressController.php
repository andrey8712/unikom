<?php


namespace App\Http\Controllers;


use App\Entityes\Customer;

class AddressController extends Controller
{

    public function index($customer_id)
    {
        $customer = Customer::find($customer_id);

        return view('address', ['customer' => $customer]);
    }

}