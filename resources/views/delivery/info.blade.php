@extends('layout')

@section('content')
    <div class="card">
        <div class="card-header bg-transparent header-elements-inline">
            <h6 class="card-title">Доставка №{{$delivery->id}}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p class="font-weight-semibold">Данные</p>
                    <ul class="list list-unstyled mb-0">
                        <li>Создан: <span class="font-weight-black">{{$delivery->created_at->format('d.m.Y h:i')}}</span></li>
                        <li>Перевозчик: <span class="font-weight-black">{{$delivery->carrier->title}}</span></li>
                        <li>Желаемая дата доставки: <span class="font-weight-black">@if($delivery->desired_date){{$delivery->desired_date->format('d.m.Y')}}@endif</span></li>
                        <li>Адрес: <span class="font-weight-black">{{$delivery->city}}, {{$delivery->street}} {{$delivery->home}}</span></li>
                        <li>Ответственный: @if($delivery->user)<span class="font-weight-black">{{$delivery->user->surname}} {{$delivery->user->name}}</span>@endif</li>
                        <li>Оплата от завода: {{$delivery->client_price }}{!!\App\Helpers\AppHelpers::currency() !!} тн.@if($delivery->payment_status)<span class="badge badge-success rounded-0">Получена</span> @else <span class="badge badge-danger rounded-0">Ожидается</span> @endif</li>
                        <li>Коментарий: <span class="font-weight-black">{{$delivery->comment}}</span></li>
                        <li>Коментарий к статусу отгружена: <span class="font-weight-black">{{$delivery->status_delivery_comment}}</span></li>
                        <li>Коментарий к статусу оплачена водителю: <span class="font-weight-black">{{$delivery->status_payment_comment}}</span></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <p class="font-weight-semibold">Водитель</p>
                    <ul class="list list-unstyled mb-0">
                        <li>ФИО: <span class="font-weight-black">{{$delivery->driver->surname}} {{$delivery->driver->name}} {{$delivery->driver->middle_name}}</span></li>
                        <li>Паспорт: <span class="font-weight-black">{{$delivery->driver->passport_series_and_number}}, Выдан {{$delivery->driver->passport_date_of_issue}}, {{$delivery->driver->passport_issued_by}}</span></li>
                        <li>Автомобиль: <span class="font-weight-black">{{$delivery->car->number}}, {{$delivery->car->model}}</span></li>
                        <li>ТТН: №<span class="font-weight-black">{{$delivery->ttn_number}}</span></li>
                        <li>Доверенность: <span class="font-weight-black">@if($delivery->send_proxy)<a href="/storage/{{$delivery->proxy_path}}" target="_blank">Просмотр</a>@else Не отпралена @endif</span></li>
                    </ul>
                </div>
            </div>
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
                @foreach($delivery->products as $product)
                    <tr>
                        <td>{{$product->product->title}}</td>
                        <td>{{$product->product_count}}тн.</td>
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
