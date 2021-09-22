<?php


namespace App\Http\Livewire\Order;


use App\Entityes\Order;
use App\Entityes\Setting;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{

    use WithPagination;

    public $customer_payment_status_comment;

    public $sortColumn = 'id';
    public $sortDirection = 'desc';
    public $perPage = 1;

    public $searchCustomerTitle = null;
    public $searchPaymentStatus = null;
    public $searchEmailStatus = null;
    public $searchDateBefore;
    public $searchDateAfter;

    public $orderId;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        '$refresh'
    ];

    public function mount()
    {

    }

    public function setId($id)
    {
        $this->orderId = $id;
    }

    public function sendEmail($id)
    {
        if(!$order = Order::find($id)) return;

        $settings = Setting::first();

        Mail::to($settings->order_email)->send(new \App\Mail\Order($order));

        $this->dispatchBrowserEvent('add_notify', ['type' => 'success', 'text' => 'Письмо отправленно.', 'title' => 'Заявка №' . $order->id]);
    }

    public function sortBy($column)
    {
        $this->sortDirection = $this->sortColumn === $column
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortColumn = $column;
    }

    /*public function setPaymentComment($comment)
    {
        $order = Order::find($this->orderId);

        $order->customer_payment_status = $comment;

        $order->saveOrFail();

        $this->emit('refresh');

        $this->dispatchBrowserEvent('add_notify', ['type' => 'success', 'text' => 'Оплата от грузополучателя получена.', 'title' => 'Заказ №' . $order->id]);
    }*/

    public function setPaymentStatus()
    {
        $order = Order::find($this->orderId);

        $validatedDate = $this->validate([
            'customer_payment_status_comment' => 'nullable|string',
        ]);

        $order->customer_payment_status = Order::PAYMENT_YES;
        $order->customer_payment_status_comment = $this->customer_payment_status_comment;
        $order->saveOrFail();

        $this->dispatchBrowserEvent('close_modal');
        $this->emit('refresh');

        $this->customer_payment_status_comment = null;

        $this->dispatchBrowserEvent('add_notify', ['type' => 'success', 'text' => 'Оплата от грузополучателя получена.', 'title' => 'Заказ №' . $order->id]);
    }

    public function delete()
    {
        if(!$this->orderId) {
            return;
        }

        $order = Order::find($this->orderId)->delete();

        $this->dispatchBrowserEvent('close_modal');
        $this->emit('refresh');

        $this->dispatchBrowserEvent('add_notify', ['type' => 'success', 'text' => 'Запись удалена.', 'title' => 'Заявка №' . $this->orderId]);
    }

    public function render()
    {

        //$orders = Order::select('*')->selectRaw('10 - 1 AS sale_profit');
        $orders = Order::select('*')->with('customer')
            //->selectRaw('(SELECT (SUM(customer_price * count) - SUM(self_price  * count)) FROM order_products WHERE order_id = orders.id) AS sale_profit')
            ->selectRaw('(SELECT (SUM(customer_price * count) - SUM(self_price  * count)) FROM order_products WHERE order_id = orders.id) AS sale_profit')
            ->selectRaw('(SELECT SUM(customer_price * count) FROM order_products WHERE order_id = orders.id) AS sum_sale')
            ->selectRaw('(SELECT SUM(self_price * count) FROM order_products WHERE order_id = orders.id) AS sum_product');

        if(!is_null($this->searchPaymentStatus) && $this->searchPaymentStatus != '') {
            $orders = $orders->where('customer_payment_status', $this->searchPaymentStatus);
        }

        if(!is_null($this->searchEmailStatus) && $this->searchEmailStatus != '') {
            $orders = $orders->where('email_send', $this->searchEmailStatus);
        }

        if($this->searchDateBefore) {
            $orders = $orders->where('desired_date', '>=', $this->searchDateBefore);
        }

        if($this->searchDateAfter) {
            $orders = $orders->where('desired_date', '<=', $this->searchDateAfter);
        }

        if($this->searchCustomerTitle) {
            $orders = $orders->whereHas('customer', function ($query) {
                $query->where('title', 'LIKE', '%' . $this->searchCustomerTitle . '%' );
            });
        }

        //$orders = $orders->selectRaw('10 - 1 AS sale_profit');

        $orders = $orders->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);
        //dd($orders);
        return view('livewire.order.table', [
            'orders' => $orders
        ])->extends('layout');
    }

}