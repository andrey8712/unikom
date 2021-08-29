<?php


namespace App\Http\Livewire;


use App\Models\User;
use Livewire\Component;

class Setting extends Component
{

    public $order_email;
    public $proxy_email;

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

    public function storeSettings()
    {
        $this->validate();

        if(!$settings = \App\Entityes\Setting::first()) {
            $settings = new \App\Entityes\Setting();
        }

        $settings->order_email = $this->order_email;
        $settings->proxy_email = $this->proxy_email;
        $settings->saveOrFail();

        $this->dispatchBrowserEvent('add_notify', ['class' => 'bg-info border-info', 'text' => 'Данные сохранены.', 'title' => 'Нстройки']);

        //return $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.settings.table', [
            'users' => User::all()
        ])->extends('layout');
    }

}