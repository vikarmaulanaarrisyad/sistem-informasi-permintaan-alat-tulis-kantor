<x-modal data-backdrop="static" data-keyboard="false">
    <x-slot name="title">
        Tambah Daftar Pengguna
    </x-slot>

    @method('POST')
    <div class="row">
        <div class="col-md-12">
            <div id="name" class="form-group">
                <label for="name">Nama</label>
                <input type="text" name="name" id="input-name" class="form-control" autocomplete="off"
                    value="{{ old('name') }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-control" fdprocessedid="arfxz" name="email"
                    autocomplete="off" value="{{ old('email') }}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role_id" id="role_id" class="form-control">
                    <option disabled selected>Pilih Role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div id="password">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" autocomplete="off">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div id="password_confirmation">
                <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password_confirmation" name="password_confirmation" id="password_confirmation"
                    class="form-control" autocomplete="off">
            </div>
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
