<?php


namespace App\Http\Livewire\Delivery;

use App\Entityes\Car;
use App\Entityes\Carrier;
use App\Entityes\Delivery;
use App\Entityes\DeliveryProducts;
use App\Entityes\Driver;
use App\Entityes\Order;
use App\Entityes\Product;
use Livewire\Component;

class Create extends Component
{

    public $surname, $name, $middle_name, $passport_series_and_number, $passport_date_of_issue, $passport_issued_by, $phone, $email, $auto_number, $auto_model, $product_id, $product_count,
    $carrier_id, $desired_date, $city, $street, $home, $comment, $loading_top, $loading_back, $loading_side, $client_price, $driver_price;

    public $order;

    public $invoiceProducts = [
        ['product_id' => 0, 'quantity' => 0]
    ];

    public function addProduct()
    {
        $this->invoiceProducts[] = [
            ['product_id' => 0, 'quantity' => 0]
        ];
    }

    public function removeProduct($i)
    {
        unset($this->invoiceProducts[$i]);
    }

    public function mount($orderId = null)
    {
        if($orderId) {
            $this->order = Order::find($orderId);
        }
    }

    public function store()
    {
        $delivery = new Delivery();

    }

    /*public $select_drive_id;

    public function store()
    {
        $delivery = new Delivery();

        $delivery->carrier_id = $this->carrier_id;
        $delivery->desired_date = $this->desired_date;
        $delivery->city = $this->city;
        $delivery->street = $this->street;
        $delivery->home = $this->home;
        $delivery->comment = $this->comment;
        $delivery->loading_top = $this->loading_top;
        $delivery->loading_back = $this->loading_back;
        $delivery->loading_side = $this->loading_side;
        $delivery->client_price = $this->client_price;
        $delivery->driver_price = $this->driver_price;
        $delivery->current_status = Delivery::STATUS_NEW;
        $delivery->payment_status = 0;

        $delivery->saveOrFail();

        $driver = null;

        if($this->select_drive_id) {
            $driver = Driver::find($this->select_drive_id);
        } else {
            if ($this->surname && $this->name && $this->passport_series_and_number) {
                $driver = new Driver();
            }
        }

        if($driver) {
            $driver->surname = $this->surname;
            $driver->name = $this->name;
            $driver->middle_name = $this->middle_name;
            $driver->passport_series_and_number = $this->passport_series_and_number;
            $driver->passport_date_of_issue = $this->passport_date_of_issue;
            $driver->passport_issued_by = $this->passport_issued_by;
            $driver->phone = $this->phone;
            $driver->email = $this->email;
            $driver->saveOrFail();

            $delivery->current_status = Delivery::STATUS_DRIVER;
            $delivery->driver_id = $driver->id;
        }

        if($this->auto_number) {
            $car = Car::create(['number' => $this->auto_number, 'model' => $this->auto_model]);
            $delivery->car_id = $car->id;
        }

        $delivery->saveOrFail();

        foreach ($this->product_id as $key => $value) {
            DeliveryProducts::create(['delivery_id' => $delivery->id, 'product_id' => $this->product_id[$key], 'product_count' => $this->product_count[$key]]);
        }

        return $this->redirect('/deliveries');
    }

    public function render()
    {

        if($this->updateId) {
            $delivery = Delivery::find($this->updateId);

            $this->carrier_id = $delivery->carrier_id;
            $this->desired_date = $delivery->desired_date;
            $this->city = $delivery->city;
            $this->street = $delivery->street;
            $this->home = $delivery->home;
            $this->comment = $delivery->comment;
            $this->loading_top = $delivery->loading_top;
            $this->loading_back = $delivery->loading_back;
            $this->loading_side = $delivery->loading_side;
            $this->client_price = $delivery->client_price;
            $this->driver_price = $delivery->driver_price;
        }

        if($this->select_drive_id) {
            $selDriver = Driver::find($this->select_drive_id);
            $this->name = $selDriver->name;
            $this->surname = $selDriver->surname;
            $this->middle_name = $selDriver->middle_name;
            $this->passport_series_and_number = $selDriver->passport_series_and_number;
            $this->passport_date_of_issue = $selDriver->passport_date_of_issue;
            $this->passport_issued_by = $selDriver->passport_issued_by;
            $this->phone = $selDriver->phone;
            $this->email = $selDriver->email;

            if($delivery = Delivery::where('driver_id', $selDriver->id)->first()) {
                $this->auto_model = $delivery->car->model;
                $this->auto_number = $delivery->car->number;
            } else {
                $this->auto_model = '';
                $this->auto_number = '';
            }
        }

        $drivers = \App\Entityes\Driver::all();

        return view('livewire.delivery.create', [
            'carriers' => Carrier::all(),
            'products' => Product::all(),
            'drivers' => $drivers
        ]);
    }*/

    public function render()
    {

        return view('livewire.delivery.create', [
            'carriers' => Carrier::all(),
            'products' => Product::all(),
            'drivers' => Driver::all()
        ])->extends('layout');
    }

}