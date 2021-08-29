<?php


namespace App\Http\Livewire;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Setting extends Component
{

    public $order_email;
    public $proxy_email;

    public $name, $surname, $email, $password;

    public function mount()
    {

        if($settings = \App\Entityes\Setting::first()) {
            $this->order_email = $settings->order_email;
            $this->proxy_email = $settings->proxy_email;
        }
    }

    protected $rules = [
        'order_email' => 'required|email',
        'proxy_email' => 'required|email',
    ];

    public function storeUser()
    {
        $user = new User();

        $this->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|email',
            'password' => 'password|string|min:6|max:10',
        ]);

        $user->name = $this->name;
        $user->surname = $this->surname;
        $user->email = $this->email;
        $user->password = Hash::make($this->password);
        $user->saveOrFail();
        $this->dispatchBrowserEvent('add_notify', ['class' => 'bg-info border-info', 'text' => $user->surname . ' ' . $user->name . ' добавлен.', 'title' => 'Сотрудник']);
        $this->dispatchBrowserEvent('close_modal');
        $this->emit('refresh');
    }

    public function storeSettings()
    {
        $this->validate();

        if(!$settings = \App\Entityes\Setting::first()) {
            $settings = new \App\Entityes\Setting();
        }

        $settings->order_email = $this->order_email;
        $settings->proxy_email = $this->proxy_email;
        $settings->saveOrFail();

        $this->dispatchBrowserEvent('add_notify', ['class' => 'bg-info border-info', 'text' => 'Данные сохранены.', 'title' => 'Настройки']);

        //return $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.settings.table', [
            'users' => User::all()
        ])->extends('layout');
    }

}