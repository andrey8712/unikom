<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Водители</h5>
        <div class="header-elements">
            <button type="button" class="btn bg-blue btn-labeled btn-labeled-left" data-toggle="modal" data-target="#createModal">
                <b><i class="icon-newspaper2"></i></b>
                Добавить водителя
            </button>
        </div>
    </div>
    <div class="dataTables_wrapper no-footer">
        <div class="datatable-header">
            <div class="dataTables_filter">
                <label>
                    <span>Поиск:</span> <input type="search" placeholder="Фамилия..." wire:model="searchTitle">
                </label>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table datatable-pagination dataTable no-footer">
            <thead>
            <tr>
                <th class="@if($sortColumn === 'id') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('id')">#</th>
                <th class="@if($sortColumn === 'surname') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('surname')">ФИО</th>
                <th class="@if($sortColumn === 'passport_series_and_number') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('passport_series_and_number')">Паспорт</th>
                <th class="@if($sortColumn === 'phone') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('phone')">Телефон</th>
                <th class="@if($sortColumn === 'email') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('email')">Email</th>
                <th class="@if($sortColumn === 'created_at') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('created_at')">Создан</th>
                <th width="150px">Изменить</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($drivers as $driver)
                <tr>
                    <td>{{ $driver->id }}</td>
                    <td>{{ $driver->surname }} {{ $driver->name }} {{ $driver->middle_name }}</td>
                    <td>{{ $driver->passport_series_and_number }}</td>
                    <td>{{ $driver->phone }}</td>
                    <td>{{ $driver->email }}</td>
                    <td>{{ $driver->created_at }}</td>
                    <td>
                        <button data-toggle="modal" data-target="#updateModal" wire:click="edit({{ $driver->id }})" type="button" class="btn btn-primary btn-icon"><i class="icon-pen2"></i></button>
                        <button type="button" class="btn btn-danger btn-icon" data-toggle="modal" data-target="#deleteModal" wire:click="setDeleteId({{ $driver->id }})"><i class="icon-bin2"></i></button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="datatable-footer">{{$drivers->links()}}</div>
    </div>
    <div wire:ignore.self id="createModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Водитель</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Фамилия</label>
                                    <input type="text" class="form-control" wire:model="surname">
                                    @error('surname')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                                <div class="col-sm-4">
                                    <label>Имя</label>
                                    <input type="text" class="form-control" wire:model="name">
                                    @error('name')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                                <div class="col-sm-4">
                                    <label>Отчество</label>
                                    <input type="text" class="form-control" wire:model="middle_name">
                                    @error('middle_name')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Номер паспорта</label>
                                    <input type="text" class="form-control" wire:model="passport_series_and_number">
                                    @error('passport_series_and_number')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                                <div class="col-sm-4">
                                    <label>Дата выдачи</label>
                                    <input type="date" class="form-control" wire:model="passport_date_of_issue">
                                    @error('passport_date_of_issue')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                                <div class="col-sm-4">
                                    <label>Кем выдан</label>
                                    <input type="text" class="form-control" wire:model="passport_issued_by">
                                    @error('passport_issued_by')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Телефон</label>
                                    <input type="text" wire:ignore onchange="@this.set('phone', this.value)" class="form-control phone" wire:model="phone">
                                    @error('phone')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                                <div class="col-sm-6">
                                    <label>Email</label>
                                    <input type="text" class="form-control" wire:model="email">
                                    @error('email')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Комментарий</label>
                                    <textarea class="form-control" wire:model="comment"></textarea>
                                    @error('comment')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
                        <button type="button" wire:click.prevent="store()"  class="btn bg-primary">Сохранить</button>
                    </div>
                </form>
                <script>
                    window.addEventListener('created', event => {
                        $('#createModal').modal('hide');
                    })
                </script>
            </div>
        </div>
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
                            <h5>Вы уверены что хотите удалить водителя "{{$surname}}"?</h5>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
                        <button type="button" wire:click.prevent="delete()"  class="btn bg-danger">Удалить</button>
                    </div>
                </form>
                <script>
                    window.addEventListener('created', event => {
                        $('#deleteModal').modal('hide');
                    })
                </script>
            </div>
        </div>
    </div>
    <div wire:ignore.self id="updateModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Водитель</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Фамилия</label>
                                    <input type="text" class="form-control" wire:model="surname">
                                    @error('surname')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                                <div class="col-sm-4">
                                    <label>Имя</label>
                                    <input type="text" class="form-control" wire:model="name">
                                    @error('name')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                                <div class="col-sm-4">
                                    <label>Отчество</label>
                                    <input type="text" class="form-control" wire:model="middle_name">
                                    @error('middle_name')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Номер паспорта</label>
                                    <input type="text" class="form-control" wire:model="passport_series_and_number">
                                    @error('passport_series_and_number')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                                <div class="col-sm-4">
                                    <label>Дата выдачи</label>
                                    <input type="date" class="form-control" wire:model="passport_date_of_issue">
                                    @error('passport_date_of_issue')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                                <div class="col-sm-4">
                                    <label>Кем выдан</label>
                                    <input type="text" class="form-control" wire:model="passport_issued_by">
                                    @error('passport_issued_by')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Телефон</label>
                                    <input type="text" wire:ignore onchange="@this.set('phone', this.value)" class="form-control phone" wire:model="phone">
                                    @error('phone')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                                <div class="col-sm-6">
                                    <label>Email</label>
                                    <input type="text" class="form-control" wire:model="email">
                                    @error('email')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Комментарий</label>
                                    <textarea class="form-control" wire:model="comment"></textarea>
                                    @error('comment')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
                        <button type="button" wire:click.prevent="update()"  class="btn bg-primary">Сохранить</button>
                    </div>
                </form>
                <script>
                    window.addEventListener('created', event => {
                        $('#updateModal').modal('hide');
                    })
                    $('.phone').inputmask({'mask': '+7 (999) 999-9999', 'clearMaskOnLostFocus' : false, 'autoUnmask': true});
                </script>
            </div>
        </div>
    </div>
    <!-- /update modal -->
</div>
