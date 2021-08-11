@extends('layout')

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
        <h5 class="card-title">Товары</h5>
        <div class="header-elements">
            <button type="button" class="btn bg-blue btn-labeled btn-labeled-left" data-toggle="modal" data-target="#modal_default">
                <b><i class="icon-newspaper2"></i></b>
                Добавить товар
            </button>
        </div>
        </div>
        @livewire('product.show')
    </div>
    <!-- Basic modal -->
    <div id="modal_default" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                @livewire('product.modal')
            </div>
        </div>
    </div>
    <!-- /basic modal -->
    <!-- Basic modal -->
    <div id="updateModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                @livewire('product.update')
            </div>
        </div>
    </div>
    <!-- /basic modal -->
@endsection