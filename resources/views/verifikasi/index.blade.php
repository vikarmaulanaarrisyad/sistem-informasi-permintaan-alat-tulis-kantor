@extends('layouts.app')

@section('title', 'Verifikasi Permintaan')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Verifikasi Permintaan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="verifikasiData(`{{ route('verifikasi-permintaan.approval') }}`)"
                        class="btn btn-primary btn-sm"><i class="fas fa-check-circle"></i> Verifikasi Permintaan</button>
                </x-slot>

                <x-table>
                    <x-slot name="thead">
                        <th>
                            <input type="checkbox" name="select_all" id="select_all">
                        </th>
                        <th>No</th>
                        <th>Prodi</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </x-slot>
                </x-table>

            </x-card>
        </div>
    </div>
    {{-- @include('permintaan.form') --}}
@endsection

@includeIf('include.datatables')
@include('include.datepicker')

@push('scripts')
    <script>
        let modal = '#modal-form';
        let button = '#submitBtn';
        let table;

        $(function() {
            $('#spinner-border').hide();
        });

        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('verifikasi-permintaan.data') }}',
            },
            columns: [{
                    data: 'select_all',
                    searchable: false,
                },
                {
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'prodi'
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
                    data: 'unit',
                },
                {
                    data: 'price',
                },
                {
                    data: 'total',
                },
            ]
        });



        $('[name=select_all]').on('click', function() {
            $(':checkbox').prop('checked', this.checked);
        });
    </script>
@endpush
