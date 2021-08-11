<?php


namespace App\Http\Livewire;


class Carrier extends CrudTable
{

    public $title, $phone, $email, $inn, $ogrn, $comment, $address;

    public $pageTitle = 'Перевозчики';
    public $createButtonTitle = 'перевозчика';

    public $searchColumn = 'title';
    public $searchPlaceholder = 'Наименование';

    public $editModal = 'carrier.update';
    public $createModal = 'carrier.create';

    public function query()
    {
        return \App\Entityes\Carrier::query();
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
            'title' => [
                'title' => 'Название',
                'sorting' => true,
                'view' => null
            ],
            'inn' => [
                'title' => 'ИНН',
                'sorting' => true,
                'view' => null
            ],
            'ogrn' => [
                'title' => 'ИНН',
                'sorting' => true,
                'view' => null
            ],
            'address' => [
                'title' => 'ИНН',
                'sorting' => true,
                'view' => null
            ],
            'phone' => [
                'title' => 'Телефон',
                'sorting' => true,
                'view' => null
            ],
            'is_default' => [
                'title' => 'Свой',
                'sorting' => true,
                'view' => function ($val) {
                    if($val) return '<i class="icon-checkmark3 text-green-800"></i>';
                    return '<i class="icon-cross3 text-danger-800"></i>';
                }
            ],
        ];
    }

    public function resetInput()
    {
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

    public function edit($id)
    {

        $this->resetInput();

        if($entity = \App\Entityes\Carrier::find($id)) {

            $this->modelId = $id;

            $this->title = $entity->title;
            $this->phone = $entity->phone;
            $this->email = $entity->email;
            $this->inn = $entity->inn;
            $this->ogrn = $entity->ogrn;
            $this->address = $entity->address;
            $this->comment = $entity->comment;
        }
    }

    protected $rules = [
        'title' => 'required|min:3',
        'phone' => 'required|string',
        'email' => 'nullable|email',
        'inn' => 'nullable|digits_between:10,12',
        'ogrn' => 'nullable|digits:13',
        'address' => 'nullable|string|min:1|max:255',
        'comment' => 'nullable|string',
    ];

    protected $validationAttributes = [
        'title' => 'Название',
        'phone' => 'Телефон',
        'email' => 'E-mail',
        'inn' => 'ИНН',
        'ogrn' => 'ОГРН',
        'address' => 'Адрес',
        'comment' => 'Коментарий',
    ];
}