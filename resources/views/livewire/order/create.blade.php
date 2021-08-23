<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Добавить заказ</h5>
    </div>
    <div class="card-body">
        <form>
            <fieldset class="mb-3">
                <legend class="text-uppercase font-size-sm font-weight-bold">Клиент</legend>
                @if(!$order)
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-float" wire:ignore>
                            <label>Выберите грузополучателя</label>
                            <select select data-placeholder="Введите название" class="form-control select-minimum" id="select-customer" data-fouc>
                                <option value=""></option>
                                @foreach($customers as $customer)
                                <option value="{{$customer->id}}">{{$customer->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group form-group-float">
                            <label>Очистить</label>
                            <span class="input-group-append">
                                <button class="btn btn-light" type="button" wire:click="clearCustomer()">X</button>
                            </span>
                        </div>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Название</label>
                            <input type="text" @if($order || $select_customer_id) readonly @endif class="form-control" wire:model="customer_title">
                            @error('customer_title')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">ИНН</label>
                            <input type="text" class="form-control" wire:model="customer_inn">
                            @error('customer_inn')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">ОГРН</label>
                            <input type="text" class="form-control" wire:model="customer_ogrn">
                            @error('customer_ogrn')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Юр. адрес</label>
                            <input type="text" class="form-control" wire:model="customer_address">
                            @error('customer_address')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Телефон</label>
                            <input type="text" @if($order || $select_customer_id) readonly @endif wire:ignore onchange="@this.set('customer_phone', this.value)" class="form-control phone" wire:model="customer_phone">
                            @error('customer_phone')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Email</label>
                            <input type="text" class="form-control" wire:model="customer_email">
                            @error('customer_email')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Лимит</label>
                            <input type="number" class="form-control" wire:model="customer_price_limit">
                            @error('customer_price_limit')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Комментарий</label>
                            <textarea class="form-control" wire:model="customer_comment"></textarea>
                            @error('customer_comment')<label class="validation-invalid-label">{{ $message }}</label>@enderror
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
                            <textarea type="text" class="form-control" wire:model="address_comment"></textarea>
                            @error('address_comment')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="mb-3" id="fieldset">
                <legend class="text-uppercase font-size-sm font-weight-bold">Товары <a class="ml-2 btn btn-sm alpha-blue text-blue-800" href="/products/">Редактировать</a> </legend>
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
                            <div class="form-group form-group-float">
                                <label>Стоимость закупа (за тонну)</label>
                                <select class="custom-select" wire:model="invoiceProducts.{{$k}}.self_price">
                                    <option>Выберите регион</option>
                                    @if($invoiceProduct['product_id'] != 0)
                                    @foreach($products as $product)
                                        @if($invoiceProduct['product_id'] == $product->id)
                                        <option value="{{$product->variant_price_1}}">Оренб. обл.: {{\App\Helpers\AppHelpers::formatPrice($product->variant_price_1)}}{!! \App\Helpers\AppHelpers::currency() !!}</option>
                                        <option value="{{$product->variant_price_3}}">Респ. Башкортостан: {{\App\Helpers\AppHelpers::formatPrice($product->variant_price_3)}}{!! \App\Helpers\AppHelpers::currency() !!}</option>
                                        <option value="{{$product->variant_price_4}}">Челяб. обл.: {{\App\Helpers\AppHelpers::formatPrice($product->variant_price_4)}}{!! \App\Helpers\AppHelpers::currency() !!}</option>
                                        <option value="{{$product->variant_price_5}}">Самовывоз: {{\App\Helpers\AppHelpers::formatPrice($product->variant_price_5)}}{!! \App\Helpers\AppHelpers::currency() !!}</option>
                                        <option value="{{$product->variant_price_2}}">Запас: {{\App\Helpers\AppHelpers::formatPrice($product->variant_price_2)}}{!! \App\Helpers\AppHelpers::currency() !!}</option>
                                        @endif;
                                    @endforeach
                                    @endif;
                                </select>
                                @error('invoiceProducts.'. $k. '.self_price')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Цена продажи (за тонну)</label>
                            <input type="number" class="form-control" wire:model="invoiceProducts.{{$k}}.customer_price">
                            @error('invoiceProducts.'. $k. '.customer_price')<label class="validation-invalid-label">{{ $message }}</label>@enderror
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
            <fieldset class="mb-3" id="fieldset">
                <legend class="text-uppercase font-size-sm font-weight-bold">Дполнительно</legend>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Желаемая дата доставки</label>
                            <input type="date" class="form-control" wire:model="desired_date">
                            @error('desired_date')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                    {{--<div class="col-md-2">
                        <label class="d-block">Предоплата от клиента</label>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" id="check1" wire:model="customer_payment_status">
                            <label class="custom-control-label" for="check1">Получена</label>
                            @error('customer_payment_status')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>--}}
                </div>
                <dvi class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Коментарий</label>
                            <textarea type="date" class="form-control" wire:model="comment"></textarea>
                            @error('comment')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                </dvi>
            </fieldset>
            <div class="d-flex justify-content-end align-items-center">
                <a href="/orders" class="btn btn-light">Отмена</a>
                {!! \App\Helpers\AppHelpers::saveButton('store()') !!}
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('.phone').inputmask({'mask': '+7 (999) 999-9999', 'clearMaskOnLostFocus' : false, 'autoUnmask': true});
            $('#select-customer').on('change', function (e) {
                var data = $('#select-customer').select2('val');
                @this.set('select_customer_id', data);
            });
            window.addEventListener('clear_customer', event => {
                console.log('clear_customer');
                /*$('#select-customer').select2({
                    minimumInputLength: 2,
                    minimumResultsForSearch: Infinity
                });*/
                $('#select2-select-customer-container').empty();
                $('#select2-select-customer-container').html('<span class="select2-selection__placeholder">Введите название</span>');
            })
        });
    </script>
</div>
