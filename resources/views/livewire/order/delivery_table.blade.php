<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">{!! $pageTitle !!}</h5>
        <div class="header-elements">
            <a href="@if($order)/orders/{{$order->id}}/deliveries/create/@else/deliveries/create/@endif" class="btn alpha-blue text-blue-800 btn-labeled btn-labeled-left">
                <b><i class="icon-plus22"></i></b>
                Добавить доставку
            </a>
        </div>
    </div>
    @if($text)
        <div class="card-body">
            <div class="toast" style="opacity: 1; max-width: none;">
                <div class="toast-body">{!! $text !!}</div>
            </div>
        </div>
    @endif
    @if(!$order)
    <div class="dataTables_wrapper no-footer">
        <div class="datatable-header">

            {{--<label>
                <span>Поиск:</span> <input type="search" placeholder="..." wire:model="search">
            </label>--}}
            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group" wire:ignore>
                        <label class="d-block">Перевозчик:</label>
                        <select class="form-control select" id="searchCarrierId" data-fouc>
                            <option value="">Любой</option>
                            @foreach($carriers as $carrier)
                                <option value="{{$carrier->id}}">{{$carrier->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group form-group-float">
                        <label class="form-group-float-label is-visible">Город:</label>
                        <input type="text" class="form-control" wire:model="searchAddress">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group form-group-float">
                        <label class="form-group-float-label is-visible">Водитель:</label>
                        <input type="text" class="form-control" wire:model="searchDriverSurnName">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group form-group-float">
                        <label class="form-group-float-label is-visible">Дата от:</label>
                        <input type="date" class="form-control" wire:model="searhDateBefore">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group form-group-float">
                        <label class="form-group-float-label is-visible">Дата до:</label>
                        <input type="date" class="form-control" wire:model="searchDateAfter">
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group" wire:ignore>
                        <label class="d-block">Оплата:</label>
                        <select class="form-control select" id="searchPaymentStatus" data-fouc>
                            <option value="">Любой</option>
                            <option value="1">Получена</option>
                            <option value="0">Ожидается</option>
                        </select>
                    </div>
                </div>
                {{--<div class="col-sm-1">
                    <div class="form-group" wire:ignore>
                        <label class="d-block">Заявка:</label>
                        <select class="form-control select" id="searchEmailStatus" data-fouc>
                            <option value="">Любой</option>
                            <option value="1">Отправлена</option>
                            <option value="0">В очереди</option>
                        </select>
                    </div>
                </div>--}}
            </div>
        </div>
    </div>
    @endif
    <div class="table-responsive">
        <table class="table table-hover datatable-pagination dataTable no-footer table-xs">
            <thead class="table-active">
            <tr>
                <th class="@if($sortColumn === 'id') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('id')">#</th>
                <th class="@if($sortColumn === 'carrier_id') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('carrier_id')">Перевозчик</th>
                <th class="@if($sortColumn === 'city') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('city')">Адрес</th>
                <th class="@if($sortColumn === 'sum_client_price') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('sum_client_price')">От завода</th>
                <th class="@if($sortColumn === 'driver_price') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('driver_price')">Водителю</th>
                <th class="@if($sortColumn === 'profit') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('profit')">Прибыль</th>
                <th class="@if($sortColumn === 'current_status') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('current_status')">Статус</th>
                <th class="@if($sortColumn === 'ttn_number') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('ttn_number')">ТТН</th>
                <th class="@if($sortColumn === 'payment_status') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('payment_status')">Оплата</th>
                <th class="@if($sortColumn === 'proxy_path') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('proxy_path')">Довер.</th>
                <th>Водитель</th>
                <th>Погр.</th>
                <th>Товары в доставке</th>
                {{--<th width="100px"></th>--}}
                <th width="170px"></th>
            </tr>
            </thead>
        @if($deliveries->count() > 0)
            <tbody>
            @foreach($deliveries as $delivery)
                <tr>
                    <td>{{$delivery->id}}</td>
                    <td>@if($delivery->carrier->is_default)<span class="text-green-800">@else<span class="text-blue-800">@endif {{$delivery->carrier->title}}</span></td>
                    <td>{{$delivery->city}}, {{$delivery->street}} {{$delivery->home}}</td>
                    <td>
                        <span class="font-weight-black">
                            {!! \App\Helpers\AppHelpers::formatPrice($delivery->sum_client_price) !!}{!! \App\Helpers\AppHelpers::currency() !!}
                        </span><br>
                        <span class="text-secondary">
                        {!! \App\Helpers\AppHelpers::formatPrice($delivery->client_price) !!}{!! \App\Helpers\AppHelpers::currency() !!} за тн.
                        </span>
                    </td>
                    <td>
                        <span class="font-weight-black">
                            {{ \App\Helpers\AppHelpers::formatPrice($delivery->driver_price) }}{!! \App\Helpers\AppHelpers::currency() !!}
                        </span>
                    </td>
                    <td>
                        <span class="font-weight-black">
                            {{ \App\Helpers\AppHelpers::formatPrice($delivery->profit) }}{!! \App\Helpers\AppHelpers::currency() !!}
                        </span>
                    </td>
                    <td>{!! $delivery->getStatusBadge() !!}</td>
                    <td>{{$delivery->ttn_number}}</td>
                    <td>@if($delivery->payment_status)<span class="badge badge-success">Получена</span>@else<span class="badge badge-danger">Нет</span> @endif </td>
                    <td>@if($delivery->proxy_path)<a class="btn btn-sm btn-icon alpha-success text-info-800 ml-1 cursor-pointer" data-toggle="modal" data-target="#proxyModal" wire:click="getProxy({{$delivery->id}})"><i class="icon-eye"></i> </a>@else<span class="badge badge-danger">Нет</span> @endif </td>
                    <td>@if($delivery->driver){!! $delivery->driver->getShortFio() !!}<br>@endif @if($delivery->car)<span class="font-weight-black">{{$delivery->car->number}}</span> {{$delivery->car->model}}@endif</td>
                    <td>@if($delivery->loading_top)В @endif @if($delivery->loading_back)З @endif @if($delivery->loading_side)Б @endif</td>
                    <td>
                        @foreach($delivery->products as $product)
                            - {{$product->product->title}}: <span class="font-weight-black">{{$product->product_count}}тн.</span><br>
                        @endforeach
                    </td>
                    {{--<td>
                        <div class="btn-group dropup">
                            <button type="button" class="btn btn-sm alpha-slate btn-icon dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-cog5"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @foreach($delivery->getStatuses() as $k => $status)
                                    @if($k == \App\Entityes\Delivery::STATUS_COMPLETE)
                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#ttnModal" wire:click="setId({{$delivery->id}})">{{$status}}</a>
                                    @else
                                        <a href="#" class="dropdown-item" wire:click="setStatus({{$delivery->id}}, {{$k}})">{{$status}}</a>
                                    @endif
                                @endforeach
                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item" wire:click="sendProxy({{$delivery->id}})">Отправить доверенность</a>
                            </div>
                        </div>
                    </td>--}}
                    <td>
                        <div class="btn-group dropup">
                            <button type="button" class="btn btn-sm alpha-slate btn-icon dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-cog5"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @foreach($delivery->getStatuses() as $k => $status)
                                    @if($k == \App\Entityes\Delivery::STATUS_COMPLETE)
                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#ttnModal" wire:click="setId({{$delivery->id}})">{{$status}}</a>
                                    @else
                                        <a href="#" class="dropdown-item" wire:click="setStatus({{$delivery->id}}, {{$k}})">{{$status}}</a>
                                    @endif
                                @endforeach
                                    @if($delivery->carrier->is_default)
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item" wire:click="setProxy({{$delivery->id}})">Отправить доверенность</a>
                                        @if(!$delivery->payment_status)
                                            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#paymentModal" wire:click="setPayment({{$delivery->id}})">Оплата от завода получена</a>
                                        @endif
                                    @endif
                            </div>
                            @if($delivery->current_status >= 4)
                                <a class="btn btn-sm btn-icon alpha-info text-info-800 ml-1 cursor-pointer" href="/deliveries/{{$delivery->id}}/info/"><i class="icon-eye"></i></a>
                            @else
                                <a class="btn btn-sm ml-1 btn-icon alpha-orange text-dark-800" href="/deliveries/{{$delivery->id}}/update/"><i class="icon-pencil"></i></a>
                            @endif
                            <a class="btn btn-icon ml-1 btn-sm alpha-danger text-danger-800" style="cursor: pointer" data-toggle="modal" data-target="#deleteModal" wire:click="setId({{$delivery->id}})"><i class="icon-trash-alt"></i> </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            <tr class="alpha-info">
                <td colspan="3">
                    <div class="text-right">
                        Итого по {{$deliveries->count()}} {{\App\Helpers\AppHelpers::num2word($deliveries->count(), ['доставке', 'доставкам', 'доставкам'])}}:
                    </div>
                </td>
                <td>
                    <span class="font-weight-black">
                        {{\App\Helpers\AppHelpers::formatPrice($deliveries->sum('sum_client_price'))}}{!! \App\Helpers\AppHelpers::currency() !!}
                    </span>
                </td>
                <td>
                    <span class="font-weight-black">
                        {{\App\Helpers\AppHelpers::formatPrice($deliveries->sum('driver_price'))}}{!! \App\Helpers\AppHelpers::currency() !!}
                    </span>
                </td>
                <td>
                    <span class="font-weight-black">
                        {{\App\Helpers\AppHelpers::formatPrice($deliveries->sum('profit'))}}{!! \App\Helpers\AppHelpers::currency() !!}
                    </span>
                </td>
                <td colspan="7">

                </td>
            </tr>
            </tbody>
        @else
            <tbody>
            <tr>
                <td colspan="14"><div class="text-center">Записей не найдено.</div></td>
            </tr>
            </tbody>
        @endif
        </table>
        <div class="datatable-footer">{{$deliveries->links()}}</div>
    </div>
    <div wire:ignore.self id="deleteModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title">Удалить запись</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="swal2-icon swal2-error swal2-animate-error-icon" style="display: flex;"><span class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span><span class="swal2-x-mark-line-right"></span></span></div>
                        <div class="text-center">
                            <h5>Вы уверены что хотите удалить доставку №{{$deliveryId}}?</h5>
                        </div>
                    </div>

                    <div class="modal-footer">
                        {!! \App\Helpers\AppHelpers::closeButton() !!}
                        <button type="button" wire:click.prevent="delete()"  class="btn alpha-danger text-danger-800">Удалить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div wire:ignore.self id="ttnModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Добавить ТТН к доставке №{{$deliveryId}}</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Номер ТТН</label>
                                        <input type="text" class="form-control" wire:model="ttn">
                                        @error('ttn')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn alpha-green text-green-800 ml-3" wire:click.prevent="setTtn()">Сохранить <i class="icon-checkmark2 ml-2"></i></button>
                        {!! \App\Helpers\AppHelpers::closeButton() !!}
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div wire:ignore.self id="proxyModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Доверенность к доставке №{{$deliveryId}}</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        {{--<div class="text-center">
                            <i class="icon-spinner2 spinner"></i>
                        </div>--}}
                        <img style="width: 100%" src="{{$imagePath}}">
                    </div>

                    <div class="modal-footer">
                        @if($proxyViewMode)
                            {!! \App\Helpers\AppHelpers::closeButton('Закрыть') !!}
                        @else
                        {!! \App\Helpers\AppHelpers::closeButton() !!}
                        <button type="button" class="btn alpha-green text-green-800 ml-3" wire:click.prevent="sendProxy({{$deliveryId}})">Отправить <i class="icon-checkmark2 ml-2"></i></button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            window.addEventListener('close_modal', event => {
                $('.modal').modal('hide');
            });

            window.addEventListener('open_proxy_modal', event => {
                $('#proxyModal').modal('show');
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
            $('.phone').inputmask({'mask': '+7 (999) 999-9999', 'clearMaskOnLostFocus' : false, 'autoUnmask': true});
            $('#per_page').on('change', function (e) {
                var data = $('#per_page').select2('val');
            @this.set('perPage', data);
            });
            $('#searchPaymentStatus').on('change', function (e) {
                var data = $('#searchPaymentStatus').select2('val');
                console.log(data);
            @this.set('searchPaymentStatus', data);
            });
            $('#searchCarrierId').on('change', function (e) {
                var data = $('#searchCarrierId').select2('val');
                console.log(data);
            @this.set('searchCarrierId', data);
            });
            $('#searchEmailStatus').on('change', function (e) {
                var data = $('#searchEmailStatus').select2('val');
                console.log(data);
            @this.set('searchEmailStatus', data);
            });
            /*$('#createModal').on('shown.bs.modal', function () {
                @this.resetInput();
            })*/
            $('#updateModal').on('hidden.bs.modal', function () {
                @this.resetInput();
            })
            $('#proxyModal').on('hidden.bs.modal', function () {
                @this.resetProxy();
            })
            /*$('#proxyModal').on('shown.bs.modal', function () {
                console.log('shown.bs.modal');
                $('#proxyModal .modal-content').block({
                    message: '<i class="icon-spinner spinner"></i>',
                    overlayCSS: {
                        backgroundColor: '#fff',
                        opacity: 0.8,
                        cursor: 'wait'
                    },
                    css: {
                        border: 0,
                        padding: 0,
                        backgroundColor: 'none'
                    }
                });
                window.setTimeout(function () {
                    $('#proxyModal .modal-content').unblock();
                }, 2000)
            });*/
        });
    </script>
</div>