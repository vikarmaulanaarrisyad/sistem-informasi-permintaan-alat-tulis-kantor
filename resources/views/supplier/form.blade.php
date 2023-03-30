<x-modal data-backdrop="static" data-keyboard="false">
    <x-slot name="title">
        Tambah Data Supplier
    </x-slot>

    @method('POST')
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name">Nama Supplier</label>
                <input id="name" class="form-control" type="text" name="name" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="email">Email Supplier</label>
                <input id="email" class="form-control" type="email" name="email" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="phone">Nomor Handphone</label>
                <input id="phone" class="form-control" type="number" name="phone" autocomplete="off" min=0>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="address">Alamat</label>
                <textarea name="address" id="address" class="form-control summernote"></textarea>
            </div>
        </div>
    </div>


    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-primary" id="submitBtn">
            <span id="spinner-border" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <i class="fas fa-save mr-1"></i>
            Simpan</button>
    </x-slot>

</x-modal>
