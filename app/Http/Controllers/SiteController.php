<?php


namespace App\Http\Controllers;


use App\Entityes\Delivery;
use App\Entityes\Order;
use Illuminate\Support\Collection;

class SiteController extends Controller
{

    public function index($date_period = 2)
    {
        $orders = new Collection();
        $deliveries = new Collection();
        //$dates = new Collection();
        $dates = '';


        $months = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
        $days = [1 => 'Понедельник', 2 => 'Вторник', 3 => 'Среда', 4 => 'Четверг', 5 => 'Пятница', 6 => 'Суббота', 7 => 'Воскресенье'];

        if($date_period == 1) {
            $ordersArr = Order::selectRaw('COUNT(id) AS count')->selectRaw('YEAR(created_at) year')->selectRaw('DAYOFWEEK(created_at) day')
                ->groupBy('year','day')
                ->orderBy('day', 'asc')
                ->get();

            $i = 0;

            foreach ($ordersArr as $order) {
                if($order->year == now()->format('Y')) {
                    $orders[$order->day] = $order->count;
                    if($i + 1 == $ordersArr->count()) {
                        $dates .= "'{$days[$order->day]}'";
                    } else {
                        $dates .= "'{$days[$order->day]}',";
                    }
                }
                $i++;
            }

            $deliveriesArr = Delivery::selectRaw('COUNT(id) AS count')->selectRaw('YEAR(created_at) year')->selectRaw('MONTH(created_at) month')
                ->groupBy('year','month')
                ->orderBy('month', 'asc')
                ->get();



            foreach ($deliveriesArr as $delivery) {
                if($delivery->year == now()->format('Y')) {
                    $deliveries[$delivery->month] = $delivery->count;
                }
            }


        } else {
            $ordersArr = Order::selectRaw('COUNT(id) AS count')->selectRaw('YEAR(created_at) year')->selectRaw('MONTH(created_at) month')
                ->groupBy('year','month')
                ->orderBy('month', 'asc')
                ->get();

            $orders = new Collection([
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 0,
                5 => 0,
                6 => 0,
                7 => 0,
                8 => 0,
                9 => 0,
                10 => 0,
                11 => 0,
                12 => 0,
            ]);

            foreach ($ordersArr as $order) {
                if($order->year == now()->format('Y')) {
                    $orders[$order->month] = $order->count;
                }
            }

            $deliveriesArr = Delivery::selectRaw('COUNT(id) AS count')->selectRaw('YEAR(created_at) year')->selectRaw('MONTH(created_at) month')
                ->groupBy('year','month')
                ->orderBy('month', 'asc')
                ->get();

            $deliveries = new Collection([
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 0,
                5 => 0,
                6 => 0,
                7 => 0,
                8 => 0,
                9 => 0,
                10 => 0,
                11 => 0,
                12 => 0,
            ]);

            foreach ($deliveriesArr as $delivery) {
                if($delivery->year == now()->format('Y')) {
                    $deliveries[$delivery->month] = $delivery->count;
                }
            }

            $dates = "'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'";

        }

        return view('index', [
            'orders' => $orders,
            'deliveries' => $deliveries,
            'dates' => $dates
        ]);
    }

}