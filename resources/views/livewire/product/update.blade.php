<form wire:submit.prevent="submit">
    <div class="modal-header">
        <h5 class="modal-title">Basic modal</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <div class="modal-body">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <label>Наименование</label>
                    <input type="text" placeholder="Цемент" class="form-control" wire:model="title">
                    @error('title')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">
                    <label>Цена регион 1</label>
                    <input type="text" placeholder="0" class="form-control" wire:model="variant_price_1">
                    @error('variant_price_1')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                </div>

                <div class="col-sm-4">
                    <label>Цена регион 2</label>
                    <input type="text" placeholder="0" class="form-control" wire:model="variant_price_2">
                    @error('variant_price_2')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                </div>

                <div class="col-sm-4">
                    <label>Цена регион 3</label>
                    <input type="text" placeholder="0" class="form-control" wire:model="variant_price_3">
                    @error('variant_price_3')<label class="validation-invalid-label">{{ $message }}</label>@enderror
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
        <button type="submit" class="btn bg-primary">Сохранить</button>
    </div>
</form>
<script>
    window.addEventListener('created', event => {
        $('#modal_default').modal('hide');
    })
</script>