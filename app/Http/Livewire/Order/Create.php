<?php


namespace App\Http\Livewire\Order;


use App\Entityes\Customer;
use App\Entityes\Order;
use App\Entityes\OrderProduct;
use App\Entityes\Product;
use Livewire\Component;

class Create extends Component
{

    public $customer_title, $customer_inn, $customer_ogrn, $customer_address, $customer_phone, $customer_email, $customer_comment, $customer_price_limit = 0,
        $desired_date, $comment, $customer_payment_status, $city, $street, $home, $address_comment;

    public $select_customer_id;
    public $invoiceProducts = [
        ['product_id' => 0, 'quantity' => 0, 'self_price' => 0, 'customer_price' => 0]
    ];

    public $order;

    public function mount($id = null)
    {

        if(!$id) {
            return;
        }

        if(!$order = Order::find($id)) {
            return;
        }

        if($order->customer_payment_status == Order::PAYMENT_YES) {
            return $this->redirect('/orders/');
        }

        $this->order = $order;
        $this->customer_title = $order->customer->title;
        $this->customer_inn = $order->customer->inn;
        $this->customer_ogrn = $order->customer->ogrn;
        $this->customer_address = $order->customer->address;
        $this->customer_phone = $order->customer->phone;
        $this->customer_email = $order->customer->email;
        $this->customer_comment = $order->customer->comment;
        $this->customer_price_limit = $order->customer->price_limit;
        $this->desired_date = $order->desired_date->format('Y-m-d');
        $this->comment = $order->comment;
        $order->city = $this->city;
        $order->street = $this->street;
        $order->home = $this->home;
        $order->address_comment = $this->address_comment;

        $this->invoiceProducts = [];

        foreach ($order->products as $product) {
            $this->invoiceProducts[] = ['product_id' => $product->product_id, 'quantity' => $product->count, 'self_price' => $product->self_price, 'customer_price' => $product->customer_price];
        }
    }

    protected $rules = [
        'customer_title' => 'required|min:3',
        'customer_inn' => 'nullable|digits_between:10,12',
        'customer_ogrn' => 'nullable|digits:13',
        'customer_address' => 'nullable|string|min:1|max:255',
        'customer_phone' => 'required|string',
        'customer_email' => 'nullable|email',
        'customer_comment' => 'nullable|string',
        'customer_price_limit' => 'nullable|integer|min:0',
        'desired_date' => 'required|date_format:"Y-m-d"',
        'comment' => 'nullable|string',
        'city' => 'required|string',
        'street' => 'required|string',
        'home' => 'required|string',
        'address_comment' => 'nullable|string',
        //'customer_payment_status' => 'nullable|bool',
        'invoiceProducts.0.product_id' => 'required|integer|min:1',
        'invoiceProducts.0.quantity' => 'required|numeric|min:1',
        'invoiceProducts.0.self_price' => 'required|integer|min:1',
        'invoiceProducts.0.customer_price' => 'required|integer|min:1',
        'invoiceProducts.*.product_id' => 'nullable|integer|min:1',
        'invoiceProducts.*.quantity' => 'nullable|numeric|min:1',
        'invoiceProducts.*.self_price' => 'required|integer|min:1',
        'invoiceProducts.*.customer_price' => 'required|integer|min:1',
    ];

    public function store()
    {
        $validatedDate = $this->validate();

        if($this->order) {
            $customer = Customer::find($this->order->customer_id);
        } else {
            if($this->select_customer_id) {
                $customer = Customer::find($this->select_customer_id);
            } else {
                $customer = new Customer();
            }
        }

        $customer->title = $this->customer_title;
        $customer->inn = $this->customer_inn;
        $customer->ogrn = $this->customer_ogrn;
        $customer->address = $this->customer_address;
        $customer->phone = $this->customer_phone;
        $customer->email = $this->customer_email;
        $customer->comment = $this->customer_comment;
        $customer->price_limit = $this->customer_price_limit;

        $customer->saveOrFail();

        if($this->order) {
            $order = Order::find($this->order->id);
        } else {
            $order = new Order();

            $order->customer_id = $customer->id;
            $order->customer_payment_status = Order::PAYMENT_NOT;
        }

        $order->desired_date = $this->desired_date;
        $order->comment = $this->comment;
        $order->city = $this->city;
        $order->street = $this->street;
        $order->home = $this->home;
        $order->address_comment = $this->address_comment;

        $order->saveOrFail();

        if($this->order) {
            foreach ($this->order->products as $product) {
                $product->delete();
            }
        }

        foreach ($this->invoiceProducts as $invoiceProduct) {
            $product = new OrderProduct();

            $product->order_id = $order->id;
            $product->product_id = $invoiceProduct['product_id'];
            $product->self_price = $invoiceProduct['self_price'];
            $product->customer_price = $invoiceProduct['customer_price'];
            $product->count = $invoiceProduct['quantity'];

            $product->saveOrFail();
        }

        return $this->redirect('/orders/');
    }

    public function clearCustomer()
    {
        $this->customer_title = '';
        $this->customer_inn = '';
        $this->customer_ogrn = '';
        $this->customer_address = '';
        $this->customer_phone = '';
        $this->customer_email = '';
        $this->customer_comment = '';
        $this->select_customer_id = '';
        $this->customer_price_limit = 0;
        $this->dispatchBrowserEvent('clear_customer');
    }

    public function addProduct()
    {
        $this->invoiceProducts[] = ['product_id' => 0, 'quantity' => 0, 'self_price' => 0, 'customer_price' => 0];
        //dd($this->invoiceProducts);
    }

    public function removeProduct($i)
    {
        unset($this->invoiceProducts[$i]);
    }

    public function render()
    {

        if($this->select_customer_id && $select_customer = Customer::find($this->select_customer_id)) {
            $this->customer_title = $select_customer->title;
            $this->customer_inn = $select_customer->inn;
            $this->customer_ogrn = $select_customer->ogrn;
            $this->customer_address = $select_customer->address;
            $this->customer_phone = $select_customer->phone;
            $this->customer_email = $select_customer->email;
            $this->customer_comment = $select_customer->comment;
            $this->customer_price_limit = $select_customer->price_limit;
        }

        return view('livewire.order.create', [
            'customers' => Customer::all(),
            'products' => Product::all()
        ])->extends('layout');
    }

}