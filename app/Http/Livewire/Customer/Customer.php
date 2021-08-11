<?php


namespace App\Http\Livewire\Customer;


use App\Helpers\AppHelpers;
use App\Http\Livewire\CrudTable;

class Customer extends CrudTable
{
    public $title, $phone, $email, $inn, $ogrn, $comment, $address, $price_limit = 0;

    public $pageTitle = 'Клиенты';
    public $createButtonTitle = 'клиента';

    public $searchColumn = 'title';
    public $searchPlaceholder = 'Наименование';

    public $editModal = 'customers.update';
    public $createModal = 'customers.create';

    public function query()
    {
        return \App\Entityes\Customer::query();
    }

    public function columns(): array
    {
        return [
            'id' => [
                'title' => '#',
                'sorting' => true,
                'view' => null
            ],
            'title' => [
                'title' => 'Название',
                'sorting' => true,
                'view' => null
            ],
            'price_limit' => [
                'title' => 'Баланс',
                'sorting' => true,
                'view' => function ($val) {
                    if($val > 0) {
                        return '<span class="text-orange-800">' . AppHelpers::formatPrice($val) . AppHelpers::currency() . '</span>';
                    }

                    return 0;
                }
            ],
            'inn' => [
                'title' => 'ИНН',
                'sorting' => true,
                'view' => null
            ],
            'ogrn' => [
                'title' => 'ОГРН',
                'sorting' => true,
                'view' => null
            ],
            'phone' => [
                'title' => 'Телефон',
                'sorting' => true,
                'view' => null
            ],
            'email' => [
                'title' => 'E-mail',
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
            /*'created_at' => [
                'title' => 'Дата создания',
                'sorting' => false,
                'view' => null
            ],*/
        ];
    }

    public function buttons(): array
    {
        return [
            function ($id) {
                return '<a class="btn btn-sm btn-icon alpha-blue text-blue-800" href="/customers/'.$id.'/address/">Адреса</a>';
            }
        ];
    }

    public function resetInput()
    {
        /*foreach ($this->validationAttributes as $k => $v) {
            $this->$$k = null;
        }*/

        $this->modelId = null;

        $this->title = null;
        $this->phone = null;
        $this->email = null;
        $this->inn = null;
        $this->ogrn = null;
        $this->address = null;
        $this->price_limit = null;
        $this->comment = null;
    }

    protected $rules = [
        'title' => 'required|min:3',
        'phone' => 'required|string',
        'email' => 'nullable|email',
        'inn' => 'nullable|digits_between:10,12',
        'ogrn' => 'nullable|digits:13',
        'address' => 'nullable|string|min:1|max:255',
        'price_limit' => 'nullable|integer|min:0',
        'comment' => 'nullable|string',
    ];

    protected $validationAttributes = [
        'title' => 'Название',
        'phone' => 'Телефон',
        'email' => 'E-mail',
        'inn' => 'ИНН',
        'ogrn' => 'ОГРН',
        'address' => 'Адрес',
        'price_limit' => 'Баланс',
        'comment' => 'Коментарий',
    ];

    public function getAttributeName($key)
    {
        return $this->validationAttributes[$key];
    }

    public function edit($id)
    {

        $this->resetErrorBag();

        if($entity = \App\Entityes\Customer::find($id)) {

            $this->modelId = $id;

            $this->title = $entity->title;
            $this->phone = $entity->phone;
            $this->email = $entity->email;
            $this->inn = $entity->inn;
            $this->ogrn = $entity->ogrn;
            $this->address = $entity->address;
            $this->price_limit = $entity->price_limit;
            $this->comment = $entity->comment;
        }
    }

}