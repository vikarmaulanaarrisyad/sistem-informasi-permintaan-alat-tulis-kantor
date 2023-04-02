<x-modal data-backdrop="static" data-keyboard="false">
    <x-slot name="title">
        Tambah Daftar Permintaan
    </x-slot>

    @method('POST')
    <input type="hidden" name="semester" value="{{ $semesterAktif->id }}">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group" id="code">
                <label for="input-code">Kode Permintaan</label>
                <input id="input-code" class="form-control" type="text" name="code">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="date">Tanggal Permintaan</label>
                <div class="input-group datepicker" id="date" data-target-input="nearest">
                    <input type="text" name="date" class="form-control datetimepicker-input" data-target="#date"
                        data-toggle="datetimepicker" />
                    <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name">Nama Barang</label>
                <select id="name" class="custom-select" name="name" autocomplete="off">
                    <option disabled selected>Pilih salah satu</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="unit">Satuan Barang</label>
                <select name="unit" id="unit" class="custom-select" disabled readonly>
                    <option disabled selected>-</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="stock">Persediaan Barang</label>
                <select name="stock" id="stock" class="custom-select" disabled readonly>
                    {{-- <option disabled selected>-</option> --}}
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="quantity">Jumlah</label>
                <input id="quantity" class="form-control" type="number" name="quantity" min="1">
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
