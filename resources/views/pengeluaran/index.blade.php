@extends('layouts.app')

@section('title', 'Daftar Barang Keluar')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Daftar Barang Keluar</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <x-card>
                <x-slot name="header">
                    <h4>Filter Barang Keluar</h4>
                </x-slot>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control float-right" name="datefilter"
                                placeholder="Filter tanggal">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select name="user2" id="user2" class="custom-select">
                                <option value="" selected>Semua status</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mr-1">
                            <select name="semester" id="semester" class="custom-select">
                                <option value="" selected>Semua semester</option>
                                @foreach ($semesters as $semester)
                                    <option value="{{ $semester->id }}" {{ $semester->id == $semesterAktif[0] ? 'selected' : '' }}>{{ $semester->name }} - {{ $semester->semester }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
            </x-card>

            <x-card>
                <x-table>
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Mengajukan</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    {{-- @include('permintaan.form') --}}
@endsection

@includeIf('include.datatables')
@includeIf('include.daterangepicker')

@push('scripts')
    <script>
        let modal = '#modal-form';
        let button = '#submitBtn';
        let table;

        $(function() {
            $('#spinner-border').hide();
            $('[name=start_date2]').val("")
            $('[name=end_date2]').val("")

        });

        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('pengeluaran-barang.data') }}',
                data: function(d) {
                    d.datefilter = $('input[name="datefilter"]').val(),
                        d.user = $('[name=user2]').val();
                    d.semester = $('[name=semester]').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'date'
                },
                {
                    data: 'code'
                },
                {
                    data: 'product'
                },
                {
                    data: 'quantity'
                },
                {
                    data: 'user',
                },

            ]
        });

        $('.datepicker').on('change.datetimepicker', function() {
            table.ajax.reload();
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            table.ajax.reload();
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            table.ajax.reload();
        });

        $('[name=user2]').on('change', function() {
            table.ajax.reload();
            $('input[name="datefilter"]').val('')
        });

        $('[name=semester]').on('change', function() {
            table.ajax.reload();
        });
    </script>
@endpush
