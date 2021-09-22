<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">{!! $pageTitle !!}</h5>
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
                                <option></option>
                                @foreach($carriers as $carrier)
                                    <option value="{{$carrier['id']}}">{{$carrier['title']}}</option>
                                @endforeach
                            </select>
                            @error('carrier_id')<label class="validation-invalid-label">{{ $message }}</label>@enderror
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
                            @error('desired_date')<label class="validation-invalid-label">{{ $message }}</label>@enderror
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
                        @error('loading_top')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        @error('loading_back')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        @error('loading_side')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                    </div>
                </div>
            </fieldset>
            <fieldset class="mb-3">
                <legend class="text-uppercase font-size-sm font-weight-bold">Адрес доставки</legend>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Город</label>
                            <input type="text" wire:ignore onchange="@this.set('city', this.value)" class="form-control city" wire:model="city">
                            @error('city')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Улица</label>
                            <input type="text" class="form-control" wire:model="street">
                            @error('street')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Строение</label>
                            <input type="text" class="form-control" wire:model="home">
                            @error('home')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Коментарий</label>
                            <textarea type="text" class="form-control" wire:model="comment"></textarea>
                            @error('comment')<label class="validation-invalid-label">{{ $message }}</label>@enderror
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
                                    @error('invoiceProducts.'. $k. '.product_id')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Объем (в тоннах)</label>
                                <input type="number" class="form-control" wire:model="invoiceProducts.{{$k}}.quantity">
                                @error('invoiceProducts.'. $k. '.quantity')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                            </div>
                        </div>
                        @if(count($invoiceProducts) != 1)
                            <div class="col-md-2">
                                <div class="form-group form-group-float" style="padding-top: 27px;">
                                    <button type="button" class="btn alpha-danger text-danger-800" wire:click.prevent="removeProduct({{$k}})">Удалить</button>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
                <button type="button" class="btn alpha-brown text-brown-800" wire:click.prevent="addProduct()">Добавить товар</button>
            </fieldset>
            <fieldset class="mb-3">
                <legend class="text-uppercase font-size-sm font-weight-bold">Водитель</legend>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-float" wire:ignore>
                            <label class="form-group-float-label is-visible">Выберите водителя</label>
                            {{--<input type="text" class="form-control" wire:model="surname">--}}
                            <select data-placeholder="Введите фамилию" class="form-control select-minimum" id="select-driver-id" data-fouc>
                                <option></option>
                                @foreach($drivers as $driver)
                                    <option value="{{$driver->id}}">{{$driver->surname}} {{$driver->name}} {{$driver->middle_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group form-group-float">
                            <label>Очистить</label>
                            <span class="input-group-append">
                                <button class="btn btn-light" type="button" wire:click="clearDriver()">X</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Фамилия</label>
                            <input type="text" @if($select_driver_id) readonly @endif class="form-control" wire:model="surname">
                            @error('surname')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Имя</label>
                            <input type="text" @if($select_driver_id) readonly @endif class="form-control" wire:model="name">
                            @error('name')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Отчество</label>
                            <input type="text" @if($select_driver_id) readonly @endif class="form-control" wire:model="middle_name">
                            @error('middle_name')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label>Телефон</label>
                            <input type="text" wire:ignore onchange="@this.set('phone', this.value)" class="form-control phone" wire:model="phone">
                            @error('phone')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Email</label>
                            <input type="text" class="form-control" wire:model="email">
                            @error('email')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Номер. паспорта (10 цифр без пробела)</label>
                            <input type="text" class="form-control" wire:model="passport_series_and_number">
                            @error('passport_series_and_number')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Дата выдачи</label>
                            <input type="date" class="form-control" wire:model="passport_date_of_issue">
                            @error('passport_date_of_issue')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Кем выдан</label>
                            <input type="text" class="form-control" wire:model="passport_issued_by">
                            @error('passport_issued_by')<label class="validation-invalid-label">{{ $message }}</label>@enderror
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
                            @error('auto_number')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Марка</label>
                            <input type="text" class="form-control" wire:model="auto_model">
                            @error('auto_model')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Плата водителю</label>
                            <input type="number" class="form-control" wire:model="driver_price">
                            @error('driver_price')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="d-flex justify-content-end align-items-center">
                <a href="/orders" class="btn btn-light">Отмена</a>
                {!! \App\Helpers\AppHelpers::saveButton('store()') !!}
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            window.addEventListener('close_modal', event => {
                $('.modal').modal('hide');
            });
            window.addEventListener('add_notify', event => {
                new PNotify({
                    title: event.detail.title,
                    text: event.detail.text,
                    //addclass: event.detail.class
                    icon: 'icon-info22',
                    type: event.detail.type
                });
            });
            window.addEventListener('clear_driver', event => {
                console.log('clear_driver');
                $('#select2-select-driver-id-container').empty();
                $('#select2-select-driver-id-container').html('<span class="select2-selection__placeholder">Введите фамилию</span>');
            })
            $('.phone').inputmask({'mask': '+7 (999) 999-9999', 'clearMaskOnLostFocus' : false, 'autoUnmask': true});
            /*$.extend($.inputmask.defaults.definitions, {
                'z': {
                    validator: "[А-яа-я]",
                    cardinality: 1
                }
            });*/
            //$('.city').inputmask({mask: "a Az{3,}"});
            $('.city').inputmask("a AX{3,}", {
                definitions: {
                    "X": {
                        validator: "[А-Яа-я -]"
                    }
                }
            });
            //$('.city').inputmask({ regex: '^[а-я] [А-Я][А-Яа-я -]*$' });
            $('#select-driver-id').on('change', function (e) {
                var data = $('#select-driver-id').select2('val');
                console.log(data);
                @this.set('select_driver_id', data);
            });
        });
    </script>
</div>