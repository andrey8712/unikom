<?php


namespace App\Http\Livewire;


use Livewire\Component;
use Livewire\WithPagination;

class Car extends Component
{
    use WithPagination;

    public $number, $model, $tonnage, $loading_top = false, $loading_back = false, $loading_side = false;

    public $updateMode = false;
    public $searchTitle = '';
    public $sortColumn = 'id';
    public $sortDirection = 'asc';
    public $deleteId;
    public $car_id;

    protected $listeners = [
        '$refresh'
    ];

    public function edit($id)
    {
        $car = \App\Entityes\Car::find($id);

        $this->car_id = $car->id;
        $this->model = $car->model;
        $this->number = $car->number;
        $this->tonnage = $car->tonnage;
        $this->loading_top = $car->loading_top;
        $this->loading_back = $car->loading_back;
        $this->loading_side = $car->loading_side;
    }

    public function store()
    {
        $validatedDate = $this->validate([
            'number' => 'required|string',
            'model' => 'required|string',
            'tonnage' => 'required|integer',
            'loading_top' => 'nullable|bool',
            'loading_back' => 'nullable|bool',
            'loading_side' => 'nullable|bool',
        ]);

        $customer = \App\Entityes\Car::create($validatedDate);

        $this->dispatchBrowserEvent('created');
        $this->emit('refresh');
        $this->resetInputFields();
    }

    public function update()
    {
        $validatedDate = $this->validate([
            'number' => 'required|string',
            'model' => 'required|string',
            'tonnage' => 'required|integer',
            'loading_top' => 'nullable|bool',
            'loading_back' => 'nullable|bool',
            'loading_side' => 'nullable|bool',
        ]);

        if ($this->car_id) {
            $driver = \App\Entityes\Car::find($this->car_id);
            $driver->update($validatedDate);
            $this->updateMode = false;
            session()->flash('message', 'Users Updated Successfully.');
            $this->dispatchBrowserEvent('created');
            $this->emit('refresh');
            $this->resetInputFields();
        }
    }

    private function resetInputFields()
    {
        $this->number = '';
        $this->model = '';
        $this->tonnage = '';
        $this->loading_top = '';
        $this->loading_back = '';
        $this->loading_side = '';
    }

    public function setDeleteId($id)
    {
        $this->deleteId = $id;

        $driver = \App\Entityes\Car::find($this->deleteId);
    }

    public function delete()
    {
        if($this->deleteId) {
            \App\Entityes\Car::find($this->deleteId)->delete();
        }

        $this->deleteId = null;
        $this->dispatchBrowserEvent('created');
        $this->emit('refresh');
        $this->resetInputFields();
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
        return view('livewire.cars.table', [
            'cars' => \App\Entityes\Car::where('number', 'LIKE', '%' . $this->searchTitle . '%' )->orderBy($this->sortColumn, $this->sortDirection)->paginate(50)
        ]);
    }

}