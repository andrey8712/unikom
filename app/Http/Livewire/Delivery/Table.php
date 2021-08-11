<?php


namespace App\Http\Livewire\Delivery;


use App\Entityes\Carrier;
use App\Entityes\Delivery;
use App\Entityes\Driver;
use App\Entityes\Order;
use App\Helpers\AppHelpers;
use App\Http\Livewire\CrudTable;
use Livewire\Component;

class Table extends CrudTable
{

    public $pageTitle = 'Доставки';
    public $createButtonTitle = 'доставку';

    public $searchColumn = 'city';
    public $searchPlaceholder = 'Наименование';

    //public $editModal = 'products.update';
    //public $createModal = 'products.create';

    public $order;

    public function mount($id = null)
    {
        if(!$id) {
            return;
        }

        if(!$order = Order::find($id)) {
            return;
        }

        /*if($order->customer_payment_status == Order::PAYMENT_YES) {
            return $this->redirect('/orders/');
        }*/

        $this->order = $order;
    }

    public function query()
    {
        if($this->order) {
            return Delivery::where('order_id', $this->order->id);
        } else {
            return Delivery::query();
        }
    }

    public function columns(): array
    {
        return [
            'id' => [
                'title' => '#',
                'sorting' => true,
                'view' => null
            ],
            'carrier_id' => [
                'title' => 'Перевозчик',
                'sorting' => true,
                'view' => function($val) {
                    if($val) {
                        $carrier = Carrier::find($val);
                        return ($carrier->is_default ? '<span class="text-green-800">' : '<span class="text-blue-800">') . $carrier->title . '</span>';
                    }
                }
            ],
            'client_price' => [
                'title' => 'Цена завода',
                'sorting' => true,
                'view' => function($val) {
                    return $val . AppHelpers::currency();
                }
            ],
            'city' => [
                'title' => 'Город',
                'sorting' => true,
                'view' => null
            ],
            'desired_date' => [
                'title' => 'Дата доставки',
                'sorting' => false,
                'view' => function($val) {
                    return $val ? $val->format('d.m.Y h:i') : null;
                }
            ],
            'created_at' => [
                'title' => 'Дата создания',
                'sorting' => false,
                'view' => function($val) {
                    return $val->format('d.m.Y h:i');
                }
            ]
        ];
    }

    public function buttons(): array
    {
        return [];
    }

    public function resetInput()
    {
        // TODO: Implement resetInput() method.
    }

    /*public $ttn, $surname, $name, $middle_name, $passport_series_and_number, $passport_date_of_issue, $passport_issued_by, $phone, $email, $auto_number, $auto_model;

    public $searchTitle = '';
    public $sortColumn = 'id';
    public $sortDirection = 'asc';
    public $deleteId;
    public $deliveryId;
    public $select_drive_id;

    protected $listeners = [
        '$refresh'
    ];

    public function setId($id)
    {
        $this->deliveryId = $id;
    }

    public function setStatus($id, $status)
    {
        if($delivery = Delivery::find($id)) {
            $delivery->current_status = $status;
            $delivery->saveOrFail();
            $this->emit('refresh');
        }
    }

    public function addTtn()
    {
        if($delivery = Delivery::find($this->deliveryId)) {
            $delivery->ttn_number = $this->ttn;
            $delivery->current_status = Delivery::STATUS_COMPLETE;
            $delivery->saveOrFail();
            $this->ttn = '';
            $this->dispatchBrowserEvent('created');
            $this->emit('refresh');
        }
    }

    public function sortBy($column)
    {
        $this->sortDirection = $this->sortColumn === $column
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortColumn = $column;
    }

    public function render()
    {
        return view('livewire.delivery.view', [
            'deliveries' => Delivery::where('id', 'LIKE', '%' . $this->searchTitle . '%' )->orderBy($this->sortColumn, $this->sortDirection)->paginate(10),
            'drivers' => Driver::all()
        ]);
    }*/

}