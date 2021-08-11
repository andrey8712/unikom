<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Создать доставку</h5>
    </div>
    <div class="card-body">
        <form method="post">
            @csrf
            <fieldset class="mb-3">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label>Перевозчик</label>
                            <select class="custom-select" wire:model="carrier_id">
                                @foreach($carriers as $carrier)
                                    <option value="{{$carrier['id']}}">{{$carrier['title']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label>Оплата от завода (за тонну)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" wire:model="client_price">
                                <span class="input-group-append">
                                        <span class="input-group-text">{!! \App\Helpers\AppHelpers::currency() !!}</span>
                                    </span>
                                @error('client_price')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Желаемая дата доставки</label>
                            <input type="date" class="form-control" wire:model="desired_date">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label class="d-block">Возможные типы погрузки</label>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" id="check1" wire:model="loading_top">
                            <label class="custom-control-label" for="check1">Верх</label>
                        </div>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" id="check2" wire:model="loading_back">
                            <label class="custom-control-label" for="check2">Зад</label>
                        </div>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" id="check3" wire:model="loading_side">
                            <label class="custom-control-label" for="check3">Бок</label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="mb-3">
                <legend class="text-uppercase font-size-sm font-weight-bold">Адрес доставки</legend>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Город</label>
                            <input type="text" class="form-control" wire:model="city">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Улица</label>
                            <input type="text" class="form-control" wire:model="street">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Строение</label>
                            <input type="text" class="form-control" wire:model="home">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Коментарий</label>
                            <textarea type="text" class="form-control" wire:model="comment"></textarea>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="mb-3" id="fieldset">
                <legend class="text-uppercase font-size-sm font-weight-bold">Товары</legend>
                @foreach($invoiceProducts as $k => $invoiceProduct)
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group form-group-float">
                                <div class="form-group form-group-float">
                                    <label>Товар</label>
                                    <select class="custom-select" wire:model="invoiceProducts.{{$k}}.product_id">
                                        <option>Выберите товар</option>
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Объем (в тоннах)</label>
                                <input type="number" class="form-control" wire:model="invoiceProducts.{{$k}}.quantity">
                            </div>
                        </div>
                        @if(count($invoiceProducts) != 1)
                            <div class="col-md-2">
                                <div class="form-group form-group-float" style="padding-top: 27px;">
                                    <button type="button" class="btn btn-danger" wire:click.prevent="removeProduct({{$k}})">Удалить</button>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
                <button type="button" class="btn btn-success" wire:click.prevent="addProduct()">Добавить товар</button>
            </fieldset>
            <fieldset class="mb-3">
                <legend class="text-uppercase font-size-sm font-weight-bold">Водитель</legend>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-float" wire:ignore>
                            <label class="form-group-float-label is-visible">Выберите водителя</label>
                            {{--<input type="text" class="form-control" wire:model="surname">--}}
                            <select data-placeholder="Введите фамилию" class="form-control select-minimum" id="select-surname" data-fouc>
                                <option></option>
                                @foreach($drivers as $driver)
                                <option value="{{$driver->id}}">{{$driver->surname}} {{$driver->name}} {{$driver->middle_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Фамилия</label>
                            <input type="text" class="form-control" wire:model="surname">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Имя</label>
                            <input type="text" class="form-control" wire:model="name">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Отчество</label>
                            <input type="text" class="form-control" wire:model="middle_name">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Телефон</label>
                            <input type="text" class="form-control" wire:model="phone">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Email</label>
                            <input type="text" class="form-control" wire:model="email">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Номер. паспорта</label>
                            <input type="text" class="form-control" wire:model="passport_series_and_number">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Дата выдачи</label>
                            <input type="date" class="form-control" wire:model="passport_date_of_issue">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Кем выдан</label>
                            <input type="text" class="form-control" wire:model="passport_issued_by">
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="mb-3">
                <legend class="text-uppercase font-size-sm font-weight-bold">Автомобиль</legend>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Гос. номер</label>
                            <input type="text" class="form-control" wire:model="auto_number">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Марка</label>
                            <input type="text" class="form-control" wire:model="auto_model">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Плата водителю</label>
                            <input type="number" class="form-control" wire:model="driver_price">
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="d-flex justify-content-end align-items-center">
                <a href="/deliveries" class="btn btn-light">Отмена</a>
                <button type="submit" class="btn bg-blue ml-3" wire:click.prevent="store()">Сохранить <i class="icon-paperplane ml-2"></i></button>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            /*window.addEventListener('created', event => {
                $('.select').select2({
                    minimumResultsForSearch: Infinity
                });
                $('.select-minimum').select2({
                    minimumInputLength: 2,
                    minimumResultsForSearch: Infinity
                });
            });*/
            $('#select-surname').on('change', function (e) {
                var data = $('#select-surname').select2("val");
                @this.set('select_drive_id', data);
            });
        });
    </script>
</div>