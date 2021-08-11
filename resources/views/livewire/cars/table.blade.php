<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Автомобили</h5>
        <div class="header-elements">
            <button type="button" class="btn bg-blue btn-labeled btn-labeled-left" data-toggle="modal" data-target="#createModal">
                <b><i class="icon-newspaper2"></i></b>
                Добавить автомобиль
            </button>
        </div>
    </div>
    <div class="dataTables_wrapper no-footer">
        <div class="datatable-header">
            <div class="dataTables_filter">
                <label>
                    <span>Поиск:</span> <input type="search" placeholder="гос.номер..." wire:model="searchTitle">
                </label>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table datatable-pagination dataTable no-footer">
            <thead>
            <tr>
                <th class="@if($sortColumn === 'id') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('id')">#</th>
                <th class="@if($sortColumn === 'model') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('model')">Модель</th>
                <th class="@if($sortColumn === 'number') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('number')">Гос.номер</th>
                <th class="@if($sortColumn === 'loading_top') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('loading_top')">Пг.верх</th>
                <th class="@if($sortColumn === 'loading_back') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('loading_back')">Пг.зад</th>
                <th class="@if($sortColumn === 'loading_side') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('loading_side')">Пг.бок</th>
                <th class="@if($sortColumn === 'created_at') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('created_at')">Создан</th>
                <th width="150px">Изменить</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($cars as $car)
                <tr>
                    <td>{{ $car->id }}</td>
                    <td>{{ $car->model }}</td>
                    <td>{{ $car->number }}</td>
                    <td>@if($car->loading_top) <i class="icon-check"></i>@else <i class="icon-x"></i> @endif</td>
                    <td>@if($car->loading_back) <i class="icon-check"></i>@else <i class="icon-x"></i> @endif</td>
                    <td>@if($car->loading_side) <i class="icon-check"></i>@else <i class="icon-x"></i> @endif</td>
                    <td>{{ $car->created_at }}</td>
                    <td>
                        <button data-toggle="modal" data-target="#updateModal" wire:click="edit({{ $car->id }})" type="button" class="btn btn-primary btn-icon"><i class="icon-pen2"></i></button>
                        <button type="button" class="btn btn-danger btn-icon" data-toggle="modal" data-target="#deleteModal" wire:click="setDeleteId({{ $car->id }})"><i class="icon-bin2"></i></button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="datatable-footer">{{$cars->links()}}</div>
    </div>
    <div wire:ignore.self id="createModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title">Автомобиль</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Модель</label>
                                    <input type="text" class="form-control" wire:model="model">
                                    @error('model')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                                <div class="col-sm-6">
                                    <label>Гос.номер</label>
                                    <input type="text" class="form-control" wire:model="number">
                                    @error('number')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="d-block font-weight-semibold">Варианты погрузки</label>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" wire:model="loading_top">
                                            Верх
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" wire:model="loading_back">
                                            Зад
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" wire:model="loading_side">
                                            Бок
                                        </label>
                                    </div>
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
                            <h5>Вы уверены что хотите удалить автомобиль?</h5>
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
                        <h5 class="modal-title">Автомобил</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-5">
                                    <label>Модель</label>
                                    <input type="text" class="form-control" wire:model="model">
                                    @error('model')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                                <div class="col-sm-5">
                                    <label>Гос.номер</label>
                                    <input type="text" class="form-control" wire:model="number">
                                    @error('number')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                                <div class="col-sm-2">
                                    <label>Тонаж</label>
                                    <input type="text" class="form-control" wire:model="tonnage">
                                    @error('tonnage')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="d-block font-weight-semibold">Варианты погрузки</label>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" wire:model="loading_top">
                                            Верх
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" wire:model="loading_back">
                                            Зад
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" wire:model="loading_side">
                                            Бок
                                        </label>
                                    </div>
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
                </script>
            </div>
        </div>
    </div>
    <!-- /update modal -->
</div>
