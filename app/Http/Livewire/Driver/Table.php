<?php


namespace App\Http\Livewire\Driver;


use App\Entityes\Driver;
use App\Http\Livewire\CrudTable;

class Table extends CrudTable
{

    public $name, $surname, $middle_name, $passport_series_and_number, $passport_date_of_issue, $passport_issued_by, $phone, $email, $comment;

    public $pageTitle = 'Водители';
    public $createButtonTitle = 'водитель';

    public $searchColumn = 'surname';
    public $searchPlaceholder = 'Фамилия';

    public $editModal = 'driver.update';
    public $createModal = 'driver.create';

    public function query()
    {
        return \App\Entityes\Driver::query();
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

    public function resetInput()
    {
        $this->name = '';
        $this->middle_name = '';
        $this->surname = '';
        $this->passport_series_and_number = '';
        $this->passport_date_of_issue = '';
        $this->passport_issued_by = '';
        $this->phone = '';
        $this->email = '';
        $this->comment = '';
    }

    protected $rules = [
        'name' => 'required|string|min:2',
        'middle_name' => 'required|string|min:3',
        'surname' => 'required|string|min:3',
        'passport_series_and_number' => 'required|string|min:10|max:10',
        'passport_date_of_issue' => 'required|date_format:"Y-m-d"',
        'passport_issued_by' => 'required|string|min:3',
        'phone' => 'required',
        'email' => 'nullable|email',
        'comment' => 'nullable|string',
    ];

    protected $validationAttributes = [
        'name' => 'Имя',
        'middle_name' => 'Отчество',
        'surname' => 'Фамилия',
        'passport_series_and_number' => 'Серия и номер',
        'passport_date_of_issue' => 'Дата выдачи',
        'passport_issued_by' => 'Кем выдан',
        'phone' => 'Телефон',
        'email' => 'E-mail',
        'comment' => 'Коментарий',
    ];

    public function edit($id)
    {

        $this->resetInput();

        if($entity = Driver::find($id)) {

            $this->modelId = $id;

            $this->name = $entity->name;
            $this->middle_name = $entity->middle_name;
            $this->surname = $entity->surname;
            $this->passport_series_and_number = $entity->passport_series_and_number;
            $this->passport_date_of_issue = $entity->passport_date_of_issue;
            $this->passport_issued_by = $entity->passport_issued_by;
            $this->phone = $entity->phone;
            $this->email = $entity->email;
            $this->comment = $entity->comment;
        }
    }

}