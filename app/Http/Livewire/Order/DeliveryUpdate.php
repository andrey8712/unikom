<?php


namespace App\Http\Livewire\Order;


use App\Entityes\Address;
use App\Entityes\Car;
use App\Entityes\Carrier;
use App\Entityes\Delivery;
use App\Entityes\DeliveryProducts;
use App\Entityes\Driver;
use App\Entityes\Order;
use App\Entityes\Product;
use Illuminate\Support\Collection;
use Livewire\Component;

class DeliveryUpdate extends Component
{

    public $surname, $name, $middle_name, $passport_series_and_number, $passport_date_of_issue, $passport_issued_by, $phone, $email, $auto_number, $auto_model, $product_id, $product_count,
        $carrier_id, $desired_date, $city, $street, $home, $comment, $loading_top, $loading_back, $loading_side, $client_price, $driver_price, $select_driver_id;

    public $order;
    public $delivery;

    public $invoiceProducts;

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

    public function mount($id)
    {
        $delivery = Delivery::find($id);

        $this->delivery = $delivery;

        if($delivery->current_status >= Delivery::STATUS_COMPLETE) {
            return redirect('/deliveries/');
        }

        if($delivery->order_id) {
            $this->order = Order::find($delivery->order_id);
        }

        $this->surname = $delivery->driver ? $delivery->driver->surname : null;
        $this->name = $delivery->driver ? $delivery->driver->name : null;
        $this->middle_name = $delivery->driver ? $delivery->driver->middle_name : null;
        $this->passport_series_and_number = $delivery->driver ? $delivery->driver->passport_series_and_number : null;
        $this->passport_date_of_issue = $delivery->driver ? $delivery->driver->passport_date_of_issue : null;
        $this->passport_issued_by = $delivery->driver ? $delivery->driver->passport_issued_by : null;
        $this->phone = $delivery->driver ? $delivery->driver->email : null;
        $this->carrier_id = $delivery->carrier_id;
        $this->city = $delivery->city;
        $this->street = $delivery->street;
        $this->home = $delivery->home;
        $this->comment = $delivery->comment;
        $this->desired_date = $delivery->desired_date ? $delivery->desired_date->format('Y-m-d') : null;
        $this->loading_top = $delivery->loading_top;
        $this->loading_back = $delivery->loading_back;
        $this->loading_side = $delivery->loading_side;
        $this->client_price = $delivery->client_price;
        $this->driver_price = $delivery->driver_price;
        $this->auto_number = $delivery->car ? $delivery->car->number : null;
        $this->auto_model = $delivery->car ? $delivery->car->model : null;

        if($delivery->products->count() > 0) {
            foreach ($delivery->products as $product) {
                $this->invoiceProducts[] = ['product_id' => $product->product_id, 'quantity' => $product->product_count];
            }
        } else {
            $this->invoiceProducts[] = ['product_id' => 0, 'quantity' => 0];
        }

    }

    public function clearDriver()
    {
        $this->select_driver_id = null;
        $this->surname = '';
        $this->name = '';
        $this->middle_name = '';
        $this->passport_series_and_number = '';
        $this->passport_date_of_issue = '';
        $this->passport_issued_by = '';
        $this->phone = '';
        $this->email = '';
        $this->dispatchBrowserEvent('clear_driver');
    }

    public function store()
    {

        $rulesCarrier = [];

        if($this->carrier_id == 1 || $this->carrier_id == 2) {
            $rulesCarrier = [
                'city' => 'required|string',
                'home' => 'required|string',
                'street' => 'required|string',
                'client_price' => 'required|integer',
                'driver_price' => 'required|integer',
                'surname' => 'required|string',
                'name' => 'required|string',
                'middle_name' => 'required|string',
                'phone' => 'required|string',
                'email' => 'nullable|email',
                'passport_series_and_number' => 'required|digits:10',
                'passport_date_of_issue' => 'required|date_format:"Y-m-d"',
                'passport_issued_by' => 'required|string',
                'auto_number' => 'required|string',
                'auto_model' => 'required|string',
            ];
        }

        $rules = [
            'carrier_id' => 'required|integer',
            'desired_date' => 'required|date_format:"Y-m-d"',
            'invoiceProducts.0.product_id' => 'required|integer|min:1',
            'invoiceProducts.0.quantity' => 'required|numeric|min:1',
            'invoiceProducts.*.product_id' => 'nullable|integer|min:1',
            'invoiceProducts.*.quantity' => 'nullable|numeric|min:1',
        ];

        $validatedDate = $this->validate($rules + $rulesCarrier);

        $delivery = Delivery::find($this->delivery->id);

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
        $delivery->driver_price = (int)$this->driver_price;

        $delivery->car_id = null;

        foreach ($delivery->products as $product) $product->delete();

        foreach ($this->invoiceProducts as $key => $value) {
            DeliveryProducts::create(['delivery_id' => $delivery->id, 'product_id' => $value['product_id'], 'product_count' => $value['quantity']]);
        }

        if($this->auto_number) {
            $car = Car::updateOrInsert(
                ['number' => $this->auto_number, 'model' => $this->auto_model]
            );

            $car = Car::where('number', $this->auto_number)->where('model', $this->auto_model)->first();

            $delivery->car_id = $car->id;
        }

        if($this->order) {
            $customer = $this->order->customer;
            Address::updateOrInsert(['city' => $this->city, 'street' => $this->street, 'home' => $this->home, 'customer_id' => $customer->id]);
        }

        $delivery->driver_id = null;

        if($this->select_driver_id) {
            $driver = Driver::find($this->select_driver_id);
        } else {
            if ($this->surname && $this->name && $this->passport_series_and_number) {
                if(!$driver = Driver::where('surname', $this->surname)->where('name', $this->name)->first()) {
                    $driver = new Driver();
                }
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

        $delivery->saveOrFail();

        $this->dispatchBrowserEvent('add_notify', ['type' => 'success', 'text' => 'Запись обновлена.', 'title' => 'Доставка №' . $delivery->id]);

        return redirect('/deliveries/');
    }

    public function render()
    {

        if($this->order) {
            $pageTitle = 'Редактировать доставку по заказу №' . $this->order->id . ' для ' . $this->order->customer->title;

            $orderProducts = new Collection();

            foreach ($this->order->products as $product) {
                $orderProducts->put($product->product_id, $product->product);
            }

        } else {
            $pageTitle = 'Редактировать доставку без заказа';

            $orderProducts = Product::all();
        }

        if($this->select_driver_id) {
            $selDriver = Driver::find($this->select_driver_id);
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
            }
        }

        return view('livewire.order.delivery_create', [
            'pageTitle' => $pageTitle,
            'carriers' => Carrier::orderBy('is_default', 'desc')->get(),
            'products' => $orderProducts,
            'drivers' => Driver::all(),
            'self_carrier' => false
        ])->extends('layout');
    }

}