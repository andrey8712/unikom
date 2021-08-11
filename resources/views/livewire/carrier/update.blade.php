<!-- Update modal -->
<div wire:ignore.self id="updateModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title">Изменить {{$createButtonTitle}}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <input type="hidden" wire:model="modelId">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Название</label>
                                <input type="text" class="form-control" wire:model="title">
                                @error('title')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                            </div>
                        </div>
                    </div>
                    <fieldset class="">
                        <legend class="text-uppercase font-size-sm font-weight-bold">Юр. информация</legend>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>ИНН</label>
                                    <input type="text" class="form-control" wire:model="inn">
                                    @error('inn')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                                <div class="col-sm-6">
                                    <label>ОРГН</label>
                                    <input type="text" class="form-control" wire:model="ogrn">
                                    @error('ogrn')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Адрес</label>
                                    <input type="text" class="form-control" wire:model="address">
                                    @error('address')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="">
                        <legend class="text-uppercase font-size-sm font-weight-bold">Контакты</legend>
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
                    </fieldset>
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
                    {!! \App\Helpers\AppHelpers::saveButton() !!}
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /update modal -->