<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Заказы</h5>
        <div class="header-elements">
            <a type="button" class="btn alpha-blue text-blue-800 btn-labeled btn-labeled-left" href="/orders/create/">
                <b><i class="icon-plus22"></i></b>
                Добавить заказ
            </a>
        </div>
    </div>
    <div class="dataTables_wrapper no-footer">
        <div class="datatable-header">

            {{--<label>
                <span>Поиск:</span> <input type="search" placeholder="..." wire:model="search">
            </label>--}}
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group form-group-float">
                        <label class="form-group-float-label is-visible">Грузополучатель:</label>
                        <input type="text" class="form-control" wire:model="searchCustomerTitle">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group form-group-float">
                        <label class="form-group-float-label is-visible">Дата от:</label>
                        <input type="date" class="form-control" wire:model="searchDateBefore">
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
                <div class="col-sm-1">
                    <div class="form-group" wire:ignore>
                        <label class="d-block">Заявка:</label>
                        <select class="form-control select" id="searchEmailStatus" data-fouc>
                            <option value="">Любой</option>
                            <option value="1">Отправлена</option>
                            <option value="0">В очереди</option>
                        </select>
                    </div>
                </div>
                {{--<div class="col-sm-1">
                    <div class="form-group" wire:ignore>
                        <label class="d-block">Очистить:</label>
                        <a href="" class="btn btn-info"><i class="icon-check"></i> </a>
                    </div>
                </div>--}}
            </div>



        </div>{{--<div class="dt-buttons">
                <button class="dt-button ml-2 btn btn-labeled btn-labeled-right alpha-indigo text-indigo-800" tabindex="0" aria-controls="DataTables_Table_0" type="button">
                    Экспорт
                    <b><i class="icon-file-excel"></i></b>
                </button>
            </div>
            <div class="dataTables_length" wire:ignore>
                <select id="per_page" class="select" wire:model="perPage">
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>--}}
    </div>
    <div class="table-responsive">
        <table class="table table-hover datatable-pagination dataTable no-footer table-xs">
            <thead class="table-active">
            <tr>
                <th class="@if($sortColumn === 'id') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('id')">#</th>
                <th class="@if($sortColumn === 'customer_id') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('customer_id')">Грузополучатель</th>
                <th class="@if($sortColumn === 'desired_date') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('desired_date')">Дата поставки</th>
                <th class="@if($sortColumn === 'customer_payment_status') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('customer_payment_status')">Оплата</th>
                <th class="@if($sortColumn === 'email_send') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('email_send')">Заявка</th>
                <th class="@if($sortColumn === 'sum_product') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('sum_product')">Закуп</th>
                <th class="@if($sortColumn === 'sum_sale') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('sum_sale')">Продажа</th>
                <th class="@if($sortColumn === 'sale_profit') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('sale_profit')">Прибыль</th>
                {{--<th>Прибыль от доставок</th>--}}
                <th>Товары в заказе</th>
                <th width="50px"></th>
                {{--<th width="60px"></th>--}}
                <th width="170px"></th>
            </tr>
            </thead>
            @if($orders->count() > 0)
                <tbody>
                @foreach($orders as $order)
                    <tr class="table-border-dashed @if($order->customer_payment_status) alpha-green @endif">
                        <td>{{$order->id}}</td>
                        <td>{{$order->customer->title}}</td>
                        <td>{{$order->desired_date->format('d.m.Y')}}</td>
                        <td>@if($order->customer_payment_status)<span class="badge badge-success rounded-0">Получена</span> @else <span class="badge badge-danger rounded-0">Ожидается</span> @endif</td>
                        <td>@if($order->email_send)<span class="badge badge-success rounded-0">Отправлена</span> @else <span class="badge badge-danger rounded-0">В очереди</span> @endif</td>
                        <td><span class="font-weight-black">{{\App\Helpers\AppHelpers::formatPrice($order->sum_product)}}{!! \App\Helpers\AppHelpers::currency() !!}</span></td>
                        <td><span class="font-weight-black">{{\App\Helpers\AppHelpers::formatPrice($order->sum_sale)}}{!! \App\Helpers\AppHelpers::currency() !!}</span></td>
                        <td><span class="font-weight-black">{{\App\Helpers\AppHelpers::formatPrice($order->sale_profit)}}{!! \App\Helpers\AppHelpers::currency() !!}</span></td>
                        {{--<td><span class="font-weight-black">0{!! \App\Helpers\AppHelpers::currency() !!}</span></td>--}}
                        <td>
                            @foreach($order->productsWithDeliveries() as $k => $product)
                            - {{$product['title']}}: <span class="font-weight-black">{{$product['count']}}тн.</span>
                                @if($product['delivery_count'] > 0)
                                Доставок <span class="font-weight-black">{{$product['delivery_count']}}</span>, на <span class="font-weight-black">{{$product['delivery_product_count']}}тн.</span>
                                @else
                                    <span class="font-weight-black text-indigo-800">Доставок нет</span>
                                @endif<br>
                            @endforeach
                        </td>
                        <td>
                            @if($order->customer_payment_status)
                                <a class="btn btn-sm btn-icon alpha-teal text-teal-800" href="/orders/{{$order->id}}/deliveries/"><i class="icon-truck"></i> </a>
                            @else

                            @endif
                        </td>
                        {{--<td>
                            <div class="btn-group dropup">
                                <button type="button" class="btn btn-sm alpha-slate btn-icon dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-cog5"></i>
                                </button>

                                <div class="dropdown-menu dropdown-menu-right">
                                    @if(!$order->customer_payment_status)
                                        <a href="#" class="dropdown-item" wire:click="setPaymentStatus({{$order->id}}, 1)">Оплата получена</a>
                                        <div class="dropdown-divider"></div>
                                    @endif
                                    @if(!$order->email_send)
                                        <a href="#" class="dropdown-item" wire:click="sendEmail({{$order->id}})">Отправить заявку</a>
                                    @endif

                                </div>
                            </div>
                        </td>--}}
                        <td>
                            <div class="btn-group dropup">
                                <button type="button" class="btn btn-sm alpha-slate btn-icon ml-1 dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-cog5"></i>
                                </button>

                                <div class="dropdown-menu dropdown-menu-right">
                                    @if(!$order->customer_payment_status)
                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#paymentModal" wire:click="setId({{$order->id}})">Оплата получена</a>
                                        <div class="dropdown-divider"></div>
                                    @endif
                                    @if(!$order->email_send)
                                        <a href="#" class="dropdown-item" wire:click="sendEmail({{$order->id}})">Отправить заявку</a>
                                    @endif

                                </div>
                            @if($order->customer_payment_status == \App\Entityes\Order::PAYMENT_YES)
                                <a class="btn btn-sm btn-icon alpha-info text-info-800 ml-1 cursor-pointer" href="/orders/info/{{$order->id}}"><i class="icon-eye"></i></a>
                            @else
                                <a class="btn btn-sm btn-icon alpha-orange text-dark-800 ml-1" href="/orders/update/{{$order->id}}/"><i class="icon-pencil"></i></a>
                            @endif
                            <a class="btn btn-icon ml-2 btn-sm alpha-danger text-danger-800 ml-1" style="cursor: pointer" data-toggle="modal" data-target="#deleteModal" wire:click="setId({{$order->id}})"><i class="icon-trash-alt"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                    <tr class="alpha-info">
                        <td colspan="5">
                            <div class="text-right">
                                Итого по {{$orders->count()}} {{\App\Helpers\AppHelpers::num2word($orders->count(), ['заказу', 'заказам', 'заказам'])}}:
                            </div>
                        </td>
                        <td>
                            <span class="font-weight-black">
                                {{\App\Helpers\AppHelpers::formatPrice($orders->sum('sum_product'))}}{!! \App\Helpers\AppHelpers::currency() !!}
                            </span>
                        </td>
                        <td>
                            <span class="font-weight-black">
                                {{\App\Helpers\AppHelpers::formatPrice($orders->sum('sum_sale'))}}{!! \App\Helpers\AppHelpers::currency() !!}
                            </span>
                        </td>
                        <td>
                            <span class="font-weight-black">
                                {{\App\Helpers\AppHelpers::formatPrice($orders->sum('sale_profit'))}}{!! \App\Helpers\AppHelpers::currency() !!}
                            </span>
                        </td>
                        <td colspan="5">

                        </td>
                    </tr>
                </tbody>
            @else
                <tbody>
                <tr>
                    <td colspan="12"><div class="text-center">Записей не найдено.</div></td>
                </tr>
                </tbody>
            @endif
        </table>
        <div class="datatable-footer">{{$orders->links()}}</div>
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
                            <h5>Вы уверены что хотите удалить заказ № {{$orderId}}?</h5>
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

    <div wire:ignore.self id="paymentModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Статус оплата получена</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Комментарий к оплате</label>
                                        <textarea class="form-control" wire:model="customer_payment_status_comment"></textarea>
                                        @error('customer_payment_status_comment')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn alpha-green text-green-800 ml-3" wire:click.prevent="setPaymentStatus()">Сохранить <i class="icon-checkmark2 ml-2"></i></button>
                        {!! \App\Helpers\AppHelpers::closeButton() !!}
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
        });
    </script>
</div>
