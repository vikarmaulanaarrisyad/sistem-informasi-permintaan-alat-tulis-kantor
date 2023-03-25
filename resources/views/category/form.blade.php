<x-modal data-backdrop="static" data-keyboard="false">
    <x-slot name="title">
        Tambah Daftar Jenis Barang
    </x-slot>

    @method('POST')
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name">Jenis Barang</label>
                <input type="text" class="form-control" fdprocessedid="arfxz" name="name" placeholder="Jenis Barang"
                    autocomplete="off">
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
