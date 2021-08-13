<?php


namespace App\Http\Livewire;


use Livewire\Component;
use Livewire\WithPagination;
use Manny\Manny;

class Driver extends Component
{

    use WithPagination;

    public $name, $surname, $middle_name, $passport_series_and_number, $passport_date_of_issue, $passport_issued_by, $phone, $email, $comment;

    public $updateMode = false;
    public $searchTitle = '';
    public $sortColumn = 'id';
    public $sortDirection = 'asc';
    public $deleteId;
    public $driver_id;

    protected $listeners = [
        '$refresh'
    ];

    public function edit($id)
    {
        $driver = \App\Entityes\Driver::find($id);

        $this->driver_id = $driver->id;
        $this->name = $driver->name;
        $this->middle_name = $driver->middle_name;
        $this->surname = $driver->surname;
        $this->passport_series_and_number = $driver->passport_series_and_number;
        $this->passport_date_of_issue = $driver->passport_date_of_issue ? $driver->passport_date_of_issue->format('Y-m-d') : null;
        $this->passport_issued_by = $driver->passport_issued_by;
        $this->phone = $driver->phone;
        $this->email = $driver->email;
        $this->comment = $driver->comment;

    }

    /*public function updated($field)
    {
        if ($field == 'phone')
        {
            $this->phone = Manny::mask($this->phone, "1 (111) 111-1111");
        }
    }*/

    public function update()
    {
        $validatedDate = $this->validate([
            'name' => 'required|string|min:2',
            'middle_name' => 'required|string|min:3',
            'surname' => 'required|string|min:3',
            'passport_series_and_number' => 'required|string|min:10|max:10',
            'passport_date_of_issue' => 'required|string',
            'passport_issued_by' => 'required|string|min:3',
            'phone' => 'required',
            'email' => 'nullable|email',
            'comment' => 'nullable|string',
        ]);

        if ($this->driver_id) {
            $driver = \App\Entityes\Driver::find($this->driver_id);
            $driver->update($validatedDate);
            $this->updateMode = false;
            session()->flash('message', 'Users Updated Successfully.');
            $this->dispatchBrowserEvent('created');
            $this->emit('refresh');
            $this->resetInputFields();
        }
    }

    public function store()
    {
        $validatedDate = $this->validate([
            'name' => 'required|string|min:2',
            'middle_name' => 'required|string|min:3',
            'surname' => 'required|string|min:3',
            'passport_series_and_number' => 'required|string|min:10|max:10',
            'passport_date_of_issue' => 'required|string',
            'passport_issued_by' => 'required|string|min:3',
            'phone' => 'required',
            'email' => 'nullable|email',
            'comment' => 'nullable|string',
        ]);

        $customer = \App\Entityes\Driver::create($validatedDate);

        $this->dispatchBrowserEvent('created');
        $this->emit('refresh');
        $this->resetInputFields();
    }

    private function resetInputFields()
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

    public function setDeleteId($id)
    {
        $this->deleteId = $id;

        $driver = \App\Entityes\Driver::find($this->deleteId);

        $this->name = $driver->name;
        $this->surname = $driver->surname;
        $this->middle_name = $driver->middle_name;
    }

    public function delete()
    {
        if($this->deleteId) {
            \App\Entityes\Driver::find($this->deleteId)->delete();
        }

        $this->deleteId = null;
        $this->dispatchBrowserEvent('created', ['fio' => $this->surname . ' ' . $this->name . ' ' . $this->middle_name]);
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
        return view('livewire.drivers.table', [
            'drivers' => \App\Entityes\Driver::where('surname', 'LIKE', '%' . $this->searchTitle . '%' )->orderBy($this->sortColumn, $this->sortDirection)->paginate(50)
        ]);
    }

}