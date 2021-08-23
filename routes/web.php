<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/create-admin', function(){
    /*$user = new \App\Models\User();

    $user->name = 'Admin';
    $user->email = 'proger.gost@gmail.com';
    $user->password = Hash::make('hw1BRJXOP');
    $user->saveOrFail();*/

    $user = new \App\Models\User();

    $user->name = 'Сергей';
    $user->email = 'predwarr@gmail.com';
    $user->password = Hash::make('Unikom56777');
    $user->saveOrFail();
});

Route::get('/test-email', function(){
    \Illuminate\Support\Facades\Mail::to('proger.gost@gmail.com')->send(new \App\Mail\Base('Тестим меил почту'));
});

Route::middleware('auth')->group(function(){

    Route::get('logout', function(){
        \Illuminate\Support\Facades\Auth::logout();
        return redirect('/login');
    });

    Route::get('/', [\App\Http\Controllers\SiteController::class, 'index']);

    Route::get('products', \App\Http\Livewire\Product::class);

    Route::get('customers/{customer_id}/address', \App\Http\Livewire\Customer\Address::class);
    Route::get('customers', \App\Http\Livewire\Customer\Customer::class);

    Route::get('carriers', \App\Http\Livewire\Carrier::class);

    Route::get('deliveries/create', \App\Http\Livewire\Order\DeliveryCreate::class);
    Route::get('deliveries/{id}/update', \App\Http\Livewire\Order\DeliveryUpdate::class);
    Route::get('deliveries/{id}/info/', [\App\Http\Controllers\OrderController::class, 'infoDelivery']);
    Route::get('deliveries', \App\Http\Livewire\Order\DeliveryTable::class);

    Route::get('orders/update/{id}', \App\Http\Livewire\Order\Create::class);
    Route::get('orders/info/{id}', [\App\Http\Controllers\OrderController::class, 'info']);
    Route::get('orders/{id}/deliveries/', \App\Http\Livewire\Order\DeliveryTable::class);
    Route::get('orders/{orderId}/deliveries/create', \App\Http\Livewire\Order\DeliveryCreate::class);
    //Route::get('orders/{orderId}/deliveries/{id}/update', \App\Http\Livewire\Order\DeliveryCreate::class);
    Route::get('orders/create', \App\Http\Livewire\Order\Create::class);
    Route::get('orders', \App\Http\Livewire\Order\Table::class);


    Route::get('drivers', \App\Http\Livewire\Driver\Table::class);
    Route::view('cars', 'livewire.cars.index');
    //Route::view('orders', 'livewire.order.index');
    //Route::view('orders/create', 'livewire.order.create');


    //Route::get('deliveries/{id}/update', [\App\Http\Controllers\DeliveryController::class, 'update']);
    //Route::post('deliveries/create', [\App\Http\Controllers\DeliveryController::class, 'store'])->name('delivery.store');
    //Route::get('deliveries', [\App\Http\Controllers\DeliveryController::class, 'index']);
});