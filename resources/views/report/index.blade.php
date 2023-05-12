@extends('layouts.app')

@section('title', 'Laporan Data Barang ' . tanggal_indonesia($start) . ' s/d ' . tanggal_indonesia($end))

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
                    <button onclick="ubahPeriode(`{{ route('report.data') }}`)" class="btn btn-sm btn-primary"><i
                            class="fas fa-pencil-alt"></i> Ubah
                        Periode</button>
                    {{-- <a target="_blank" href="{{ route('report.export_pdf', compact('start', 'end')) }}"
                        class="btn btn-danger"><i class="fas fa-file-pdf"></i> Export PDF</a>
                    <a target="_blank" href="{{ route('report.export_excel', compact('start', 'end')) }}"
                        class="btn btn-success"><i class="fas fa-file-excel"></i> Export Excel</a> --}}
                </div>
            </x-card>

            <x-card>
                <x-table>
                    <x-slot name="thead">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Barang</th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('report.form')
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
        });

        table = $('#table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('report.data') }}'
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
                    data: 'product',
                    searchable: false,
                    sortable: false
                },

            ],
            paginate: false,
            searching: false,
            bInfo: false,
            order: []
        });


        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            table.ajax.reload();
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            table.ajax.reload();
        });

        function ubahPeriode(url, title = "Ubah periode tanggal dan jenis laporan") {
            $(`${modal}`).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('GET');

            $('#spinner-border').hide();
            $(button).prop('disabled', false).show();

            resetForm(`${modal} form`);
        }

        function submitForm(originalForm) {
            $(button).prop('disabled', true);
            $('#spinner-border').show();

            $.ajax({
                type: "GET",
                url: $(originalForm).attr('action'),
                data: new FormData(originalForm),
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    $(modal).modal('hide');
                    $(button).prop('disabled', false);
                    $('#spinner-border').hide();
                    table.ajax.reload();
                },
                errors: function(errors) {
                    console.log(errors);
                }
            });
        }
    </script>
@endpush
