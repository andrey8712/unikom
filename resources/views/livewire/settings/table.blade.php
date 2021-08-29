<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Настройки</h5>
                {{--<div class="header-elements">
                    <a type="button" class="btn alpha-blue text-blue-800 btn-labeled btn-labeled-left" href="/orders/create/">
                        <b><i class="icon-plus22"></i></b>
                        Добавить заказ
                    </a>
                </div>--}}
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Email для отправки заявок на завод:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" wire:model="order_email">
                            @error('order_email')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Email для отправки довереностей:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" wire:model="proxy_email">
                            @error('proxy_email')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        {{--<a href="/orders" class="btn btn-light">Отмена</a>--}}
                        {!! \App\Helpers\AppHelpers::saveButton('storeSettings()') !!}
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Сотрудники</h5>
                <div class="header-elements">
                    <a type="button" data-toggle="modal" data-target="#userModal" class="btn alpha-blue text-blue-800 btn-labeled btn-labeled-left">
                        <b><i class="icon-plus22"></i></b>
                        Добавить
                    </a>
                </div>
            </div>
            <div class="card-body">
                <ul>
                @foreach($users as $user)
                    <li>{{$user->email}}: {{$user->surname}} {{$user->name}}</li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div wire:ignore.self id="userModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Добавить сотрудника</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Имя</label>
                                        <input type="text" class="form-control" wire:model="name">
                                        @error('name')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Фамилия</label>
                                        <input type="text" class="form-control" wire:model="surname">
                                        @error('surname')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Email</label>
                                        <input type="text" class="form-control" wire:model="email">
                                        @error('email')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Пароль</label>
                                        <input type="text" class="form-control" wire:model="password">
                                        @error('password')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn alpha-green text-green-800 ml-3" wire:click.prevent="storeUser()">Сохранить <i class="icon-checkmark2 ml-2"></i></button>
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
                    type: 'success'
                });
            });
        });
    </script>
</div>
