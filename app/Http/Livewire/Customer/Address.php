<?php


namespace App\Http\Livewire\Customer;


use App\Http\Livewire\CrudTable;

class Address extends CrudTable
{
    public $city, $street, $home, $comment;

    public $createButtonTitle = 'адрес';

    public $editModal = 'customers.address_update';
    public $createModal = 'customers.address_create';

    public $customer;

    public function mount($customer_id)
    {
        $this->customer = \App\Entityes\Customer::find($customer_id);
        $this->pageTitle = 'Адреса доставок клиента: <a href="/customers/">' . $this->customer->title . '</a>';
    }

    public function query()
    {
        return \App\Entityes\Address::where('customer_id', $this->customer->id);
    }

    public function buttons(): array
    {
        return [];
    }

    public function columns(): array
    {
        return [
            'id' => [
                'title' => '#',
                'sorting' => true,
                'view' => null
            ],
            'city' => [
                'title' => 'Город',
                'sorting' => true,
                'view' => null
            ],
            'street' => [
                'title' => 'Улица',
                'sorting' => true,
                'view' => null
            ],
            'home' => [
                'title' => 'Строение',
                'sorting' => true,
                'view' => null
            ],
            'comment' => [
                'title' => 'Комментарий',
                'sorting' => true,
                'view' => function ($val) {
                    if(strlen($val) > 30) {
                        return '<span class="" data-popup="popover" data-content="' . $val . '">' . mb_strimwidth($val, 0, 30, "...") . '</span>';
                    }

                    return $val;
                }
            ],
        ];
    }

    protected $rules = [
        'city' => 'required|string',
        'street' => 'required|string',
        'home' => 'nullable|string',
        'comment' => 'nullable|string',
    ];

    protected $validationAttributes = [
        'city' => 'Город',
        'street' => 'Улица',
        'home' => 'Строение',
        'comment' => 'Комментарий',
    ];

    public function store()
    {
        $validatedDate = $this->validate();
        $validatedDate['customer_id'] = $this->customer->id;
        $entity = \App\Entityes\Address::create($validatedDate);

        $this->resetInput();

        $this->dispatchBrowserEvent('close_modal');
        $this->setInfoNotify($entity->city . ' ул. ' . $entity->street . ' стр. ' . $entity->home, 'Запись добавлена.');
        $this->emit('refresh');
    }


    public function resetInput()
    {
        $this->city = '';
        $this->street = '';
        $this->home = '';
        $this->comment = '';
    }

    public function edit($id)
    {
        $address = \App\Entityes\Address::find($id);

        $this->city = $address->city;
        $this->street = $address->street;
        $this->home = $address->home;
        $this->comment = $address->comment;

        $this->modelId = $address->id;
    }

    public function update()
    {
        $validatedDate = $this->validate();

        if($entity = \App\Entityes\Address::find($this->modelId)) {
            $entity->update($validatedDate);
            $this->resetInput();
            $this->dispatchBrowserEvent('close_modal');
            $this->setInfoNotify($entity->city . ' ул. ' . $entity->street . ' стр. ' . $entity->home, 'Запись изменена.');
            $this->emit('refresh');
        }
    }

}