<div>
    <div class="dataTables_wrapper no-footer">
        <div class="datatable-header">
            <div class="dataTables_filter">
                <label>
                    <span>Поиск:</span> <input type="search" placeholder="Наименование..." wire:model="searchTitle">
                </label>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table datatable-pagination dataTable no-footer">
            <thead>
                <tr>
                    <th class="@if($sortColumn === 'id') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('id')">
                    #</th>
                    <th class="@if($sortColumn === 'title') {{$sortDirection === 'asc' ? 'sorting_asc' : 'sorting_desc'}} @else sorting @endif" wire:click="sortBy('title')">Наименование</th>
                    <th>Цена регион 1</th>
                    <th>Цена регион 2</th>
                    <th>Цена регион 3</th>
                    <th width="150px">Изменить</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->variant_price_1 }}</td>
                    <td>{{ $product->variant_price_2 }}</td>
                    <td>{{ $product->variant_price_3 }}</td>
                    <td>
                        <button data-toggle="modal" data-target="#updateModal" wire:click="edit({{ $product->id }})" type="button" class="btn btn-primary btn-icon"><i class="icon-pen2"></i></button>
                        <button type="button" class="btn btn-danger btn-icon"><i class="icon-bin2"></i></button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="datatable-footer">{{$products->links()}}</div>
    </div>
</div>