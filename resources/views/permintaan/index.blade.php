@extends('layouts.app')

@section('title', 'Daftar Permintaan')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Daftar Permintaan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="addForm(`{{ route('permintaan-barang.store') }}`)" class="btn btn-primary btn-sm"><i
                            class="fas fa-plus-circle"></i> Tambah Data</button>
                </x-slot>
                <div class="d-flex">
                    <div class="form-group mr-4">
                        <label for="status2">Status</label>
                        <select name="status2" id="status2" class="custom-select">
                            <option value="" selected>Semua</option>
                            <option value="process" {{ request('status') == 'process' ? 'selected' : '' }}>Proses</option>
                            <option value="submit" {{ request('status') == 'submit' ? 'selected' : '' }}>Pending</option>
                            <option value="finish" {{ request('status') == 'finish' ? 'selected' : '' }}>Selesai
                            </option>
                        </select>
                    </div>

                    <div class="form-group mr-4">
                        <label for="semester">Semester</label>
                        <select name="semester" id="semester" class="custom-select">
                            <option value="" selected>Semua</option>
                            <option value="process" {{ request('status') == 'process' ? 'selected' : '' }}>Proses</option>
                            <option value="submit" {{ request('status') == 'submit' ? 'selected' : '' }}>Pending</option>
                            <option value="finish" {{ request('status') == 'finish' ? 'selected' : '' }}>Selesai
                            </option>
                        </select>
                    </div>

                    <div class="d-flex">
                        <div class="form-group">
                            <label for="my-input">Filter tanggal</label>
                            <input type="text" class="form-control float-right" name="datefilter">
                        </div>
                    </div>
                </div>

                <x-table>
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('permintaan.form')
@endsection

@include('include.select2')
@includeIf('include.datatables')
@include('include.datepicker')
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
                url: '{{ route('permintaan-barang.data') }}',
                data: function(d) {
                    d.datefilter = $('input[name="datefilter"]').val(),
                        d.status = $('[name=status2]').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
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
                    data: 'status',
                },
                {
                    data: 'aksi',
                    sortable: false,
                    searchable: false
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

        $('[name=status2]').on('change', function() {
            table.ajax.reload();
        });


        function addForm(url, title = 'Tambah Daftar Barang') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('POST');

            $('#spinner-border').hide();
            $(button).prop('disabled', false).show();

            resetForm(`${modal} form`);

            $(`${modal} #stock`).prop('disabled', true);

            $('#code').prop('disabled', true).hide();
            $('#name').prop('disabled', false);
            $('#unit').prop('disabled', true).trigger('change').val("-");
            $('#categories').prop('disabled', false);
            $('#price').prop('disabled', false);
            $('#stock').prop('disabled', true).trigger('change').val('-');

            getDataPermintaan();

        }

        function editForm(url, title = 'Edit Daftar Barang') {
            $.get(url)
                .done(response => {
                    $(modal).modal('show');

                    getDataPermintaan();

                    $(`${modal} .modal-title`).text(title);
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} [name=_method]`).val('PUT');

                    $('#spinner-border').hide();
                    $(button).prop('disabled', false).show();

                    resetForm(`${modal} form`);
                    loopForm(response.data);

                    $('#code').prop('disabled', true).show();
                    $('#input-code').prop('disabled', true).val(response.data.code);
                    $('#name').prop('disabled', true);
                    $('#unit').prop('disabled', true);
                    $('#stock').prop('disabled', true);

                    $('#name')
                        .val(response.data.product_id)
                        .trigger('change')
                        .prop('disabled', true);

                })
                .fail(errors => {
                    Swall.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);

                });
        }

        function detailForm(url, title = 'Detail Daftar Barang') {
            $.get(url)
                .done(response => {
                    $(modal).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    resetForm(`${modal} form`);
                    loopForm(response.data);

                    $(button).hide();
                    $('#code').prop('disabled', true).show();
                    $('#input-code').prop('disabled', true).val(response.data.code);
                    $('#name').prop('disabled', true);
                    $('#unit').prop('disabled', true);
                    $('#categories').prop('disabled', true);
                    $('#price').prop('disabled', true).val(format_uang(response.data.price));
                    $('#stock').prop('disabled', true);

                    let selectedCategories = [];
                    response.data.categories.forEach(item => {
                        selectedCategories.push(item.id);
                    });
                    $('#categories')
                        .val(selectedCategories)
                        .trigger('change');
                })

        }

        function submitForm(originalForm) {

            $(button).prop('disabled', true);
            $('#spinner-border').show();

            $.post({
                    url: $(originalForm).attr('action'),
                    data: new FormData(originalForm),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false
                })
                .done(response => {
                    $(modal).modal('hide');
                    if (response.status = 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        })
                    }
                    $(button).prop('disabled', false);
                    $('#spinner-border').hide();
                    table.ajax.reload();
                })
                .fail(errors => {
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    if (errors.status == 422) {
                        $('#spinner-border').hide()
                        $(button).prop('disabled', false);
                        loopErrors(errors.responseJSON.errors);
                        return;
                    }
                });
        }

        function deleteData(url, name) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true,
            })
            swalWithBootstrapButtons.fire({
                title: 'Apakah anda yakin?',
                text: 'Anda akan menghapus ' + name +
                    ' !',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Iya, Hapus!',
                cancelButtonText: 'Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(url, {
                            '_method': 'delete'
                        })
                        .done(response => {
                            if (response.status = 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                                table.ajax.reload();
                            }
                        })
                        .fail(errors => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Opps! Gagal!',
                                text: errors.responseJSON.message,
                                showConfirmButton: false,
                                timer: 3000
                            })
                            table.ajax.reload();
                        });
                }
            })
        }

        function getDataPermintaan() {
            $('#name').on('change', function() {
                let productId = $('[name=name]').val();
                if (productId) {
                    $.ajax({
                        type: "GET",
                        url: "/permintaan-barang/product/" + productId,
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data) {
                                $('#unit').empty();
                                $('#stock').empty();
                                $.each(data, function(key, unit) {
                                    $('select[name="unit"]').append(
                                        '<option value="' + key +
                                        '">' + unit.satuan.name +
                                        '</option>');

                                    $('select[name="stock"]').append(
                                        '<option value="' + key +
                                        '">' + unit.stock +
                                        '</option>');
                                });
                            }
                        }
                    });
                }
            });
        }
    </script>
@endpush
