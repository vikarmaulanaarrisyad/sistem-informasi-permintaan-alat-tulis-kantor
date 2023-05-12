<x-modal size="modal-lg" method="POST">
    <x-slot name="title">
        Tambah
    </x-slot>

    @method('POST')

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Jenis Laporan</label>
                <select name="laporan" id="jenis-laporan" class="custom-select">
                    <option value="masuk">Laporan Masuk</option>
                    <option value="keluar">Laporan Keluar</option>
                </select>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <input type="text" class="form-control float-right" name="datefilter" placeholder="Filter Tanggal"
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
