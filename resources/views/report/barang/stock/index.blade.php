@extends('layouts.app')

@section('title', 'Laporan Data Stock Barang')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-card>
                <x-slot name="header">
                    <h4>Filter Laporan</h4>
                </x-slot>
                <div class="btn-group">
                    <button data-toggle="modal" data-target="#modal-form" class="btn btn-primary"><i
                            class="fas fa-pencil-alt"></i> Ubah Periode</button>
                    {{-- <a target="_blank" href="{{ route('report.export_pdf', compact('start', 'end')) }}"
                        class="btn btn-danger"><i class="fas fa-file-pdf"></i> Export PDF</a>
                    <a target="_blank" href="{{ route('report.export_excel', compact('start', 'end')) }}"
                        class="btn btn-success"><i class="fas fa-file-excel"></i> Export Excel</a> --}}
                </div>
            </x-card>

            <x-card>
                <x-slot name="header">
                    <h5>Laporan Data Stok Barang Periode Tanggal
                        {{ tanggal_indonesia($start) . ' s/d ' . tanggal_indonesia($end) }}
                    </h5>
                </x-slot>
                <x-table>
                    <x-slot name="thead">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Stok Masuk</th>
                            <th>Stok Keluar</th>
                            <th>Sisa Stok</th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('report.barang.stock.form')
@endsection

@includeIf('include.datepicker')
@includeIf('include.datatables')

@push('scripts')
    <script>
        let modal = '#modal-form';
        let button = '#submitBtn';
        let table;

        $(function() {
            $('#spinner-border').hide();
        });

        table = $('#table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('report.barang.masuk.data', compact('start', 'end')) }}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'tanggal',
                    searchable: false,
                    sortable: false
                },

                {
                    data: 'stok_masuk',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'stok_keluar',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'sisa_stok',
                    searchable: false,
                    sortable: false
                },

            ],
            paginate: false,
            searching: false,
            bInfo: false,
            order: []
        });
    </script>
@endpush
