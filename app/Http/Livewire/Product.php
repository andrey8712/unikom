<?php


namespace App\Http\Livewire;


use App\Helpers\AppHelpers;
use Manny\Manny;

class Product extends CrudTable
{

    public $pageTitle = 'Товары';
    public $createButtonTitle = 'товар';

    public $searchColumn = 'title';
    public $searchPlaceholder = 'Наименование';

    public $editModal = 'products.update';
    public $createModal = 'products.create';

    public $title, $variant_price_1, $variant_price_2, $variant_price_3, $variant_price_4, $variant_price_5;

    public function query()
    {
        return \App\Entityes\Product::query();
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
                'title' => 'Наименование',
                'sorting' => true,
                'view' => null
            ],
            'variant_price_1' => [
                'title' => 'Оренб. обл.',
                'sorting' => true,
                'view' => function($val) {
                    return $val . AppHelpers::currency();
                }
            ],
            'variant_price_3' => [
                'title' => 'Респ. Башкортостан',
                'sorting' => true,
                'view' => function($val) {
                    return $val . AppHelpers::currency();
                }
            ],
            'variant_price_4' => [
                'title' => 'Челяб. обл.',
                'sorting' => true,
                'view' => function($val) {
                    return $val . AppHelpers::currency();
                }
            ],
            'variant_price_5' => [
                'title' => 'Самовывоз',
                'sorting' => true,
                'view' => function($val) {
                    return $val . AppHelpers::currency();
                }
            ],
            'variant_price_2' => [
                'title' => 'Запас',
                'sorting' => true,
                'view' => function($val) {
                    return $val . AppHelpers::currency();
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
        return [];
    }

    public function edit($id)
    {

        $this->resetInput();

        if($entity = \App\Entityes\Product::find($id)) {

            $this->modelId = $id;

            $this->title = $entity->title;
            $this->variant_price_1 = $entity->variant_price_1;
            $this->variant_price_2 = $entity->variant_price_2;
            $this->variant_price_3 = $entity->variant_price_3;
            $this->variant_price_4 = $entity->variant_price_4;
            $this->variant_price_5 = $entity->variant_price_5;
        }
    }

    public function update()
    {
        $validatedDate = $this->validate();

        if($entity = \App\Entityes\Product::find($this->modelId)) {
            $entity->update($validatedDate);
            $this->resetInput();
            $this->dispatchBrowserEvent('close_modal');
            $this->setInfoNotify($entity->title, 'Запись изменена.');
            $this->emit('refresh');
        }
    }

    protected $rules = [
        'title' => 'required|string|min:3',
        'variant_price_1' => 'required|integer|min:10',
        'variant_price_2' => 'required|integer|min:10',
        'variant_price_3' => 'required|integer|min:10',
        'variant_price_4' => 'required|integer|min:10',
        'variant_price_5' => 'required|integer|min:10',
    ];

    protected $validationAttributes = [
        'title' => 'Наименование',
        'variant_price_1' => 'Цена',
        'variant_price_2' => 'Цена',
        'variant_price_3' => 'Цена',
        'variant_price_4' => 'Цена',
        'variant_price_5' => 'Цена'
    ];

    public function resetInput()
    {
        $this->modelId = null;
        $this->title = null;
        $this->variant_price_1 = null;
        $this->variant_price_2 = null;
        $this->variant_price_3 = null;
        $this->variant_price_4 = null;
        $this->variant_price_5 = null;
    }

    public function store()
    {
        $validatedDate = $this->validate();

        $entity = \App\Entityes\Product::create($validatedDate);

        $this->resetInput();

        $this->dispatchBrowserEvent('close_modal');
        $this->setInfoNotify($entity->title, 'Запись Добавлена.');
        $this->emit('refresh');

    }
}