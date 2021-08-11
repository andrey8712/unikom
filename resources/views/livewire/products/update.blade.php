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
                                <label>Наименование</label>
                                <input type="text" class="form-control" wire:model="title">
                                @error('title')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                            </div>
                        </div>
                    </div>
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold">Цена закупа</legend>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Оренбургская обл.</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" wire:model="variant_price_1">
                                        <span class="input-group-append">
                                            <span class="input-group-text">{!! \App\Helpers\AppHelpers::currency() !!}</span>
                                        </span>
                                        @error('variant_price_1')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>Запас</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" wire:model="variant_price_2">
                                        <span class="input-group-append">
                                            <span class="input-group-text">{!! \App\Helpers\AppHelpers::currency() !!}</span>
                                        </span>
                                        @error('variant_price_2')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Республика Башкортостан</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" wire:model="variant_price_3">
                                        <span class="input-group-append">
                                            <span class="input-group-text">{!! \App\Helpers\AppHelpers::currency() !!}</span>
                                        </span>
                                        @error('variant_price_3')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>Челябинская обл.</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" wire:model="variant_price_4">
                                        <span class="input-group-append">
                                            <span class="input-group-text">{!! \App\Helpers\AppHelpers::currency() !!}</span>
                                        </span>
                                        @error('variant_price_4')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Самовывоз</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" wire:model="variant_price_5">
                                        <span class="input-group-append">
                                            <span class="input-group-text">{!! \App\Helpers\AppHelpers::currency() !!}</span>
                                        </span>
                                        @error('variant_price_5')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                                    </div>
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
    {{--<script>
        $('.phone').inputmask({'mask': '+7 (999) 999-9999', 'clearMaskOnLostFocus' : false, 'autoUnmask': true});
    </script>--}}
</div>
<!-- /update modal -->