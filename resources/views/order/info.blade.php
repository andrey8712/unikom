@extends('layout')

@section('content')
    <div class="card">
        <div class="card-header bg-transparent header-elements-inline">
            <h6 class="card-title">Заказ №{{$order->id}}</h6>
            {{--<div class="header-elements">
                <button type="button" class="btn btn-light btn-sm"><i class="icon-file-check mr-2"></i> Save</button>
                <button type="button" class="btn btn-light btn-sm ml-3"><i class="icon-printer mr-2"></i> Print</button>
            </div>--}}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p class="font-weight-semibold">Данные</p>
                    <ul class="list list-unstyled mb-0">
                        <li>Создан: <span class="font-weight-black">{{$order->created_at->format('d.m.Y h:i')}}</span></li>
                        <li>Желаемая дата доставки: <span class="font-weight-black">{{$order->desired_date->format('d.m.Y')}}</span></li>
                        <li>Адрес: <span class="font-weight-black">{{$order->city}}, {{$order->street}} {{$order->home}}</span></li>
                        <li>Коментарий к адресу: <span class="font-weight-black">{{$order->address_comment}}</span></li>
                        <li>Ответственный: @if($order->user)<span class="font-weight-black">{{$order->user->surname}} {{$order->user->name}}</span>@endif</li>
                        <li>Оплата от грузополучателя: @if($order->customer_payment_status)<span class="badge badge-success rounded-0">Получена</span> @else <span class="badge badge-danger rounded-0">Ожидается</span> @endif</li>
                        <li>Коментарий к оплате: <span class="font-weight-black">{{$order->customer_payment_status_comment}}</span></li>
                        <li>Заявка на завод: @if($order->email_send)<span class="badge badge-success rounded-0">Отправлена</span> @else <span class="badge badge-danger rounded-0">В очереди</span> @endif</li>
                        <li>Коментарий к заказу: <span class="font-weight-black">{{$order->comment}}</span></li>
                        <li>Погрузка: <span class="font-weight-black">@if($order->loading_top)В @endif @if($order->loading_back)З @endif @if($order->loading_side)Б @endif</span></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <p class="font-weight-semibold">Грузополучатель</p>
                    <ul class="list list-unstyled mb-0">
                        <li>Название: <span class="font-weight-black">{{$order->customer->title}}</span></li>
                        <li>ИНН: <span class="font-weight-black">{{$order->customer->inn}}</span></li>
                        <li>ОГРН: <span class="font-weight-black">{{$order->customer->ogrn}}</span></li>
                        <li>Юр. адрес: <span class="font-weight-black">{{$order->customer->address}}</span></li>
                        <li>Телефон: <span class="font-weight-black">{{$order->customer->phone}}</span></li>
                        <li>Email: <span class="font-weight-black">{{$order->customer->email}}</span></li>
                        <li>Коментарий: <span class="font-weight-black">{{$order->customer->comment}}</span></li>
                    </ul>
                </div>
            </div>
            <h7 class="title">Товары:</h7>
        </div>

        <div class="table-responsive">
            <table class="table table-lg">
                <thead>
                <tr>
                    <th>Наименование</th>
                    <th>Кол-во</th>
                    <th>Закуп</th>
                    <th>Продажа</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->products as $product)
                    <tr>
                        <td>{{$product->product->title}}</td>
                        <td>{{$product->count}}тн.</td>
                        <td>{{\App\Helpers\AppHelpers::formatPrice($product->self_price)}}{!! \App\Helpers\AppHelpers::currency() !!}</td>
                        <td>{{\App\Helpers\AppHelpers::formatPrice($product->customer_price)}}{!! \App\Helpers\AppHelpers::currency() !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{--<div class="card-body">
            <h7 class="title">Доставки:</h7>
        </div>
        <div class="table-responsive">
            <table class="table table-lg">
                <thead>
                <tr>
                    <th>Наименование</th>
                    <th>Кол-во</th>
                    <th>Закуп</th>
                    <th>Продажа</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>--}}
    </div>
@endsection
