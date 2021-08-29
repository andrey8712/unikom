<?php


namespace App\Http\Livewire\Order;


use App\Entityes\Address;
use App\Entityes\Car;
use App\Entityes\Carrier;
use App\Entityes\Customer;
use App\Entityes\Delivery;
use App\Entityes\DeliveryProducts;
use App\Entityes\Driver;
use App\Entityes\Order;
use App\Entityes\Product;
use Illuminate\Support\Collection;
use Livewire\Component;

class DeliveryCreate extends Component
{

    public $surname, $name, $middle_name, $passport_series_and_number, $passport_date_of_issue, $passport_issued_by, $phone, $email, $auto_number, $auto_model, $product_id, $product_count,
        $carrier_id, $desired_date, $city, $street, $home, $comment, $loading_top, $loading_back, $loading_side, $client_price, $driver_price, $select_driver_id;

    public $order;

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

    public function mount($orderId = null)
    {
        if($orderId) {
            $this->order = Order::where('id', $orderId)->with('products')->first();
            $customer = $this->order->customer;

            /*if($customer->addresses->count() > 0) {
                $this->city = $customer->addresses->last()->city;
                $this->street = $customer->addresses->last()->street;
                $this->home = $customer->addresses->last()->home;
                $this->comment = $customer->addresses->last()->comment;
            }*/

            $this->city = $this->order->city;
            $this->street = $this->order->street;
            $this->home = $this->order->home;
            $this->comment = $this->order->address_comment;
            $this->loading_top = $this->order->loading_top;
            $this->loading_back = $this->order->loading_back;
            $this->loading_side = $this->order->loading_side;

            $orderProducts = new Collection();

            foreach ($this->order->products as $product) {
                $orderProducts->push($product);
            }

            $this->invoiceProducts = [];

            $arr = [];

            foreach ($orderProducts as $product) {
                if(isset($arr[$product->product_id])) {
                    $arr[$product->product_id] += $product->count;
                } else {
                    $arr[$product->product_id] = $product->count;
                }
            }

            if($this->order->deliveries->count() > 0) {
                foreach ($this->order->deliveries as $delivery) {
                    foreach ($delivery->products as $product) {
                        if(isset($arr[$product->product_id])) {
                            $arr[$product->product_id] -= $product->product_count;
                        }
                    }
                }
            }

            foreach ($arr as $k => $value) {
                if($value > 0) {
                    $this->invoiceProducts[] = [
                        'product_id' => $k,
                        'quantity' => $value
                    ];
                }
            }
        } else {
            $this->invoiceProducts[] = [
                'product_id' => null,
                'quantity' => 0
            ];
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
            'loading_top' => 'required_without_all:loading_back,loading_side',
            'loading_back' => 'required_without_all:loading_top,loading_side',
            'loading_side' => 'required_without_all:loading_top,loading_back',
        ];

        $validatedDate = $this->validate($rules + $rulesCarrier);

        $delivery = new Delivery();

        $delivery->order_id = $this->order ? $this->order->id : null;
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
        $delivery->current_status = Delivery::STATUS_NEW;
        $delivery->payment_status = 0;
        $delivery->created_by = auth()->id();

        $delivery->saveOrFail();

        if($this->order) {
            $customer = $this->order->customer;
            Address::updateOrInsert(['city' => $this->city, 'street' => $this->street, 'home' => $this->home, 'customer_id' => $customer->id]);
        }

        $driver = null;

        if($this->select_driver_id) {
            $driver = Driver::find($this->select_driver_id);
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

        foreach ($this->invoiceProducts as $key => $value) {
            //dd($value);
            DeliveryProducts::create(['delivery_id' => $delivery->id, 'product_id' => $value['product_id'], 'product_count' => $value['quantity']]);
        }

        if($this->order) {
            return $this->redirect('/orders/');
        } else {
            return $this->redirect('/deliveries/');
        }
    }

    public function render()
    {

        if($this->order) {
            $pageTitle = 'Добавить доставку по заказу №' . $this->order->id . ' для ' . $this->order->customer->title;

            $orderProducts = new Collection();

            foreach ($this->order->products as $product) {
                $orderProducts->put($product->product_id, $product->product);
            }

        } else {
            $pageTitle = 'Добавить доставку без заказа';

            $orderProducts = Product::all();
        }

        if($this->select_driver_id) {
            $selDriver = Driver::find($this->select_driver_id);
            $this->name = $selDriver->name;
            $this->surname = $selDriver->surname;
            $this->middle_name = $selDriver->middle_name;
            $this->passport_series_and_number = $selDriver->passport_series_and_number;
            $this->passport_date_of_issue = $selDriver->passport_date_of_issue ? $selDriver->passport_date_of_issue->format('Y-m-d') : null;
            $this->passport_issued_by = $selDriver->passport_issued_by;
            $this->phone = $selDriver->phone;
            $this->email = $selDriver->email;

            if($delivery = Delivery::where('driver_id', $selDriver->id)->first()) {
                $this->auto_model = $delivery->car->model;
                $this->auto_number = $delivery->car->number;
            }
        }

        $self_carrier = false;

        if($this->carrier_id && $carrier = Carrier::where('id', $this->carrier_id)->where('is_default', 1)->first()) {
            $self_carrier = true;
        }

        return view('livewire.order.delivery_create', [
            'pageTitle' => $pageTitle,
            'carriers' => Carrier::orderBy('is_default', 'desc')->get(),
            'products' => $orderProducts,
            'drivers' => Driver::all(),
            'self_carrier' => $self_carrier
        ])->extends('layout');
    }

}