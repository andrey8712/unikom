<?php


namespace App\Http\Livewire;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class CrudTable
 * @package App\Http\Livewire
 *
 * @property Model $model
 */
abstract class CrudTable extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $pageTitle = 'Таблица';
    public $createButtonTitle = 'Запись';

    public $search = '';
    public $searchColumn = null;
    public $searchPlaceholder = 'Введите значение';
    public $sortColumn = 'id';
    public $sortDirection = 'asc';
    public $perPage = 25;

    public $modelId;
    public $modelTitle;

    public $buttonDelete = [
        'title' => 'Удалить',
        'class' => 'alpha-danger text-danger-800'
    ];

    public $buttonEdit = [
        /*'type' => 'href',
        'url' => 'products',*/
        'type' => 'wire'
    ];

    public $editModal;
    public $createModal;

    protected $listeners = [
        '$refresh'
    ];

    public function sortBy($column)
    {
        $this->sortDirection = $this->sortColumn === $column
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortColumn = $column;
    }

    /**
     * The base query with search and filters for the table.
     *
     * @return Builder|Relation
     */
    abstract public function query();

    /**
     * The array defining the columns of the table.
     *
     * @return array
     */
    abstract public function columns(): array;

    /**
     * The array defining the columns of the table.
     *
     * @return array
     */
    abstract public function buttons(): array;

    public function setId($id)
    {
        $this->modelId = $id;

        $query = $this->query();

        if($this->modelId) {
            $model = $query->find($this->modelId);
            $this->modelTitle = $model->title;
        }
    }

    abstract public function resetInput();

    public function delete()
    {
        $query = $this->query();

        if($this->modelId) {
            $query->find($this->modelId)->delete();
        }

        $this->modelId = null;
        $this->dispatchBrowserEvent('close_modal');
        $this->setInfoNotify('Запись удалена!');
        $this->emit('refresh');
    }

    public function setInfoNotify($text, $title = 'Успешно!')
    {
        $this->dispatchBrowserEvent('add_notify', ['class' => 'bg-info border-info', 'text' => $text, 'title' => $title]);
    }

    public function store()
    {
        $validatedDate = $this->validate();

        $query = $this->query();

        $entity = $query->create($validatedDate);

        $this->resetInput();

        $this->dispatchBrowserEvent('close_modal');
        $this->setInfoNotify($entity->title, 'Запись добавлена.');
        $this->emit('refresh');
    }

    public function update()
    {
        $validatedDate = $this->validate();

        $query = $this->query();

        if($entity = $query->find($this->modelId)) {
            $entity->update($validatedDate);
            $this->resetInput();
            $this->dispatchBrowserEvent('close_modal');
            $this->setInfoNotify($entity->title, 'Запись изменена.');
            $this->emit('refresh');
        }
    }

    public function render()
    {
        $query = $this->query();
        //$model = get_class($query->getModel());

        //$model::create();
        //dd(get_class($query->getModel()));

        if($this->searchColumn) {
            $entities = $query->where($this->searchColumn, 'LIKE', '%' . $this->search . '%' )->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);
        } else {
            $entities = $query->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);
        }

        return view('livewire.crud.table', [
            'pageTitle' => $this->pageTitle,
            'createButtonTitle' => $this->createButtonTitle,
            'columns' => $this->columns(),
            'buttons' => $this->buttons(),
            'buttonDelete' => $this->buttonDelete,
            'buttonEdit' => $this->buttonEdit,
            'editModal' => $this->editModal,
            'createModal' => $this->createModal,
            'model' => $entities,
        ])->extends('layout');
    }
}