<?php


namespace App\Http\Livewire\Driver;


use App\Http\Livewire\CrudTable;

class Table extends CrudTable
{

    public $pageTitle = 'Водители';
    public $createButtonTitle = 'водитель';

    public $searchColumn = 'title';
    public $searchPlaceholder = 'Фамилия';

    public function query()
    {
        return \App\Entityes\Driver::query();
    }

    public function columns(): array
    {
        return [
            'id' => [
                'title' => '#',
                'sorting' => true,
                'view' => null
            ],
            'surname' => [
                'title' => 'Фамилия',
                'sorting' => true,
                'view' => null
            ],
            'name' => [
                'title' => 'Имя',
                'sorting' => true,
                'view' => null
            ],
            'middle_name' => [
                'title' => 'Отчество',
                'sorting' => true,
                'view' => null
            ],
            'passport_series_and_number' => [
                'title' => 'Паспорт',
                'sorting' => true,
                'view' => null
            ],
            'phone' => [
                'title' => 'Телефон',
                'sorting' => true,
                'view' => null
            ]
        ];
    }

}