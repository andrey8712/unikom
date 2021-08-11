<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Доставки</h5>
        <div class="header-elements">
            <a href="/deliveries/create" class="btn bg-blue btn-labeled btn-labeled-left">
                <b><i class="icon-newspaper2"></i></b>
                Добавить доставку
            </a>
        </div>
    </div>
    <div class="dataTables_wrapper no-footer">
        <div class="datatable-header">
            <div class="dataTables_filter">
                <label>
                    <span>Поиск:</span> <input type="search" placeholder="номер..." wire:model="searchTitle">
                </label>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table datatable-pagination dataTable no-footer">
            <thead>
            <tr>
                <th>#</th>
                <th>Перевозчик</th>
                <th>Адрес</th>
                <th>Водитель</th>
                <th>Авто</th>
                <th>Товары</th>
                <th>Сумма от завода</th>
                <th>Оплата от завода</th>
                <th>Плата водителю</th>
                <th>Прибыль</th>
                <th>ТТН</th>
                <th>Дата создания</th>
                <th>Статус</th>
                <th>Статусы</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
                @foreach($deliveries as $delivery)
                    <tr>
                        <td>{{$delivery->id}}</td>
                        <td>{{$delivery->carrier->title}}</td>
                        <td>{{$delivery->city}} {{$delivery->street}} {{$delivery->home}}</td>
                        <td>@if($delivery->driver){{$delivery->driver->surname}} {{$delivery->driver->name}} {{$delivery->driver->middle_name}}@else <a href="/deliveries/{{$delivery->id}}/update" class="badge badge-info">Добавить</a> @endif</td>
                        <td>@if($delivery->car){{$delivery->car->number}}  <span class="text-black-50">({{$delivery->car->model}})</span>@else  -  @endif</td>
                        <td>
                            @foreach($delivery->products as $product)
                                {{$product->product->title}} ({{$product->product_count}}),
                            @endforeach
                        </td>
                        <td>{{$delivery->client_price}}₽</td>
                        <td><span class="badge badge-secondary">Нет</span> </td>
                        <td>{{$delivery->driver_price}}₽</td>
                        <td>@if($delivery->driver_price){{$delivery->client_price - $delivery->driver_price}}₽ @else - @endif</td>
                        <td>@if(!$delivery->ttn_number) <a href="" data-toggle="modal" data-target="#add_ttn" class="badge badge-info" wire:click="setId({{ $delivery->id }})">Добавить</a> @else{{$delivery->ttn_number}}@endif</td>
                        <td>{{$delivery->created_at}}</td>
                        <td>{!! $delivery->getStatusBadge() !!}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Изменить</button>
                                <div class="dropdown-menu">
                                    @foreach($delivery->getStatuses() as $i => $status)
                                    <a href="#" class="dropdown-item" wire:click="setStatus({{$delivery->id}}, {{$i}})">{{$status}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Действия</button>

                                <div class="dropdown-menu">
                                    <a href="#" class="dropdown-item">Отправить заявку</a>
                                    <a href="#" class="dropdown-item">Отправить доверенность</a>
                                    <a href="#" class="dropdown-item">Отправтиь инфо водителю</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="datatable-footer"></div>
    </div>
    <div id="add_ttn" class="modal fade" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Добавить ТТН</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" wire:model="deliveryId">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Номер ТТН</label>
                                    <input type="text" class="form-control" wire:model="ttn">
                                    @error('ttn')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn bg-primary" wire:click.prevent="addTtn()">Сохранить</button>
                    </div>
                </form>
                <script>
                    window.addEventListener('created', event => {
                        $('#add_ttn').modal('hide');
                    })
                </script>
            </div>
        </div>
    </div>
    <div id="add_driver" class="modal fade" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Добавить ТТН</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" wire:model="deliveryId">
                        <div class="form-group">
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
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn bg-primary" wire:click.prevent="addTtn()">Сохранить</button>
                    </div>
                </form>
                <script>
                    window.addEventListener('created', event => {
                        $('#add_driver').modal('hide');
                    })
                </script>
            </div>
        </div>
    </div>
</div>