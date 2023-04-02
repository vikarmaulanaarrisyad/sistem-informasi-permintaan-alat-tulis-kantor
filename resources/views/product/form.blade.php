<x-modal data-backdrop="static" data-keyboard="false">
    <x-slot name="title">
        Tambah Daftar Barang
    </x-slot>

    @method('POST')
    <div class="row">
        <div class="col-md-12">
            <div id="code" class="form-group">
                <label for="code">Kode Barang</label>
                <input type="text" id="input-code" class="form-control" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name">Nama Barang</label>
                <input type="text" id="name" class="form-control" fdprocessedid="arfxz" name="name"
                    autocomplete="off">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="unit">Satuan Barang</label>
                <select name="unit" id="unit" class="custom-select">
                    <option disabled selected>Pilih salah satu</option>
                    @foreach ($dataSatuan as $satuan)
                        <option value="{{ $satuan->id }}">{{ $satuan->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="categories">Jenis Barang</label>
                <select name="categories[]" id="categories" class="select2" multiple>
                    @foreach ($dataJenisBarang as $barang)
                        <option value="{{ $barang->id }}">{{ $barang->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="price">Harga Barang</label>
                <input type="text" name="price" id="price" class="form-control" name="name"
                    autocomplete="off" onkeyup="format_uang(this)" min="0" value="0">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="stock">Stok</label>
                <input type="text" name="stock" id="stock" class="form-control" name="name"
                    autocomplete="off" onkeyup="format_uang(this)" min="0" value="0">
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
