<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">{!! $pageTitle !!}</h5>
        <div class="header-elements">
            <button type="button" class="btn alpha-blue text-blue-800 btn-labeled btn-labeled-left" data-toggle="modal" data-target="#createModal">
                <b><i class="icon-plus22"></i></b>
                Добавить {{$createButtonTitle}}
            </button>
        </div>
    </div>
    <div class="dataTables_wrapper no-footer">
        <div class="datatable-header">
            @if($searchColumn)
            <div class="dataTables_filter">
                <label>
                    <span>Поиск:</span> <input type="search" placeholder="{{$searchPlaceholder}}..." wire:model="search">
                </label>
            </div>
            @endif
            {{--<div class="dt-buttons">
                <button class="dt-button ml-2 btn btn-labeled btn-labeled-right alpha-indigo text-indigo-800" tabindex="0" aria-controls="DataTables_Table_0" type="button">
                    Экспорт
                    <b><i class="icon-file-excel"></i></b>
                </button>
            </div>--}}
            <div class="dataTables_length" wire:ignore>
                <select id="per_page" class="select" wire:model="perPage">
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover datatable-pagination dataTable no-footer table-xs">
            <thead class="table-active">
            <tr>
                @foreach($columns as $k => $column)
                    @if($column['sorting'])
                        <th class="@if($sortColumn === $k) {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('{{$k}}')">{{$column['title']}}</th>
                    @else
                        <th class="">{{$column['title']}}</th>
                    @endif
                @endforeach
                @if(count($buttons) > 0)
                    <th width="60px"></th>
                @endif
                <th width="200px"></th>
            </tr>
            </thead>
            @if($model->count() > 0)
            <tbody>
                @foreach($model as $item)
                    <tr class="table-border-dashed">
                        @foreach($columns as $k => $column)
                            @if($column['view'])
                                <td>{!!$column['view']($item->$k)!!}</td>
                            @else
                                <td>{{$item->$k}}</td>
                            @endif
                        @endforeach
                        @if($buttons)
                            <td>
                            @foreach($buttons as $button)
                                {!! $button($item->id) !!}
                            @endforeach
                            </td>
                        @endif
                        <td>
                            @if($buttonEdit)
                                <a class="btn btn-sm btn-icon alpha-orange text-orange-800"
                                        @if($buttonEdit['type'] == 'href')
                                            href="/{{$buttonEdit['url']}}/{{$item->id}}/"
                                        @else
                                            style="cursor: pointer" data-toggle="modal" data-target="#updateModal" wire:click="edit({{$item->id}})"
                                        @endif
                                >Изменить</a>
                            @endif
                            @if($buttonDelete)
                                <a class="btn btn-icon ml-2 btn-sm alpha-danger text-danger-800" style="cursor: pointer" data-toggle="modal" data-target="#deleteModal" wire:click="setId({{$item->id}})">Удалить</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            @else
                <tbody>
                    <tr>
                        <td colspan="{{count($columns) + 1}}"><div class="text-center">Записей не найдено.</div></td>
                    </tr>
                </tbody>
            @endif
        </table>
        <div class="datatable-footer">{{$model->links()}}</div>
    </div>
    @if($editModal)
        @include('livewire.' . $editModal)
    @endif
    @if($createModal)
        @include('livewire.' . $createModal)
    @endif
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
                            <h5>Вы уверены что хотите удалить {{$createButtonTitle}}:</h5>
                            <h4>"{{$modelTitle}}"</h4>
                        </div>
                    </div>

                    <div class="modal-footer">
                        {!! \App\Helpers\AppHelpers::closeButton() !!}
                        <button type="button" wire:click.prevent="delete()"  class="btn alpha-danger text-danger-800">Удалить</button>
                    </div>
                </form>
                {{--<script>
                    window.addEventListener('complete', event => {
                        $('#deleteModal').modal('hide');
                    });
                </script>--}}
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
                    type: 'info'
                });
            });
            $('.phone').inputmask({'mask': '+7 (999) 999-9999', 'clearMaskOnLostFocus' : false, 'autoUnmask': true});
            $('.city').inputmask({mask: "a a{3,}"});
            $('#per_page').on('change', function (e) {
                var data = $('#per_page').select2('val');
                @this.set('perPage', data);
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
