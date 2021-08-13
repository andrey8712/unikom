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
                                <label>Номер. паспорта (10 цифр без пробела)</label>
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
                    {!! \App\Helpers\AppHelpers::closeButton() !!}
                    {!! \App\Helpers\AppHelpers::saveButton('store()') !!}
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /create modal -->