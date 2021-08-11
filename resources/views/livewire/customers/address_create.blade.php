<!-- Create modal -->
<div wire:ignore.self id="createModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title">Создать {{$createButtonTitle}}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">
                                <label>Город</label>
                                <input type="text" class="form-control" wire:model="city">
                                @error('city')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                            </div>
                            <div class="col-sm-6">
                                <label>Улица</label>
                                <input type="text" class="form-control" wire:model="street">
                                @error('street')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                            </div>
                            <div class="col-sm-2">
                                <label>Строение</label>
                                <input type="text" class="form-control" wire:model="home">
                                @error('home')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                            </div>
                        </div>
                    </div>
                    <fieldset class="">
                        <legend class="text-uppercase font-size-sm font-weight-bold">Дополнительно</legend>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Комментарий</label>
                                    <textarea class="form-control" rows="3" cols="4" wire:model="comment"></textarea>
                                    @error('comment')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="modal-footer">
                    {!! \App\Helpers\AppHelpers::closeButton() !!}
                    {!! \App\Helpers\AppHelpers::saveButton('store()') !!}
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /create modal -->