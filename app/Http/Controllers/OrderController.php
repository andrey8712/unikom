<?php


namespace App\Http\Controllers;


use App\Entityes\Delivery;
use App\Entityes\Order;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderController extends Controller
{

    public function info($id)
    {
        if(!$order = Order::where('id', $id)->with('customer')->first()) {
            throw new NotFoundHttpException();
        }

        return view('order.info', ['order' => $order]);
    }

    public function infoDelivery($id)
    {
        if(!$delivery = Delivery::where('id', $id)->first()) {
            throw new NotFoundHttpException();
        }

        return view('delivery.info', ['delivery' => $delivery]);
    }

}