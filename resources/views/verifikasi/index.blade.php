@extends('layouts.app')

@section('title', 'Verifikasi Pengajuan')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Verifikasi Pengajuan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-card>
                <x-slot name="header">
                    <button disabled id="button-verifikasi-all"
                        onclick="verifikasiPermintaanTerpilih(`{{ route('verifikasi-permintaan.approval') }}`)"
                        class="btn btn-primary btn-sm"><i class="fas fa-check-circle"></i> Verifikasi Pengajuan</button>
                </x-slot>

                <x-table class="table-verifikasi-permintaan">
                    <x-slot name="thead">
                        <th>
                            <input type="checkbox" name="select_all" id="select_all" class="select_all">
                        </th>
                        <th>No</th>
                        <th>Mengajukan</th>
                        <th>Semester</th>
                        <th>Jumlah Item</th>
                        <th>Total</th>
                        <th>Status Pengajuan</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>

            </x-card>
        </div>
    </div>
@endsection

@includeIf('include.datatables')
@include('include.datepicker')

@push('scripts')
    <script>
        let modal = '#modal-form';
        let button = '#submitBtn';
        let isChek = 0;
        let table;

        $(function() {
            $('#spinner-border').hide();
        });

        table1 = $('.table-verifikasi-permintaan').DataTable({
            processing: true,
            serverside: true,
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
                    data: 'semester_ajuan',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'total_ajuan',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'total',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'status_pengajuan',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'aksi',
                    searchable: false,
                    sortable: false
                },
            ]
        });

        $("#select_all").on('click', function() {
            var isChecked = $("#select_all").prop('checked');
            $(".submission_id").prop('checked', isChecked);
            $("#button-verifikasi-all").prop('disabled', !isChecked);
        })

        $("#table tbody").on('click', '.submission_id', function() {
            if ($(this).prop('checked') != true) {
                $("#select_all").prop('checked', false);
            }

            let semua_checkbox = $("#table tbody .submission_id:checked")
            let button_verifikasi_permintaan = (semua_checkbox.length > 0)
            $("#button-verifikasi-all").prop('disabled', !button_verifikasi_permintaan)
        })

        function verifikasiPermintaanTerpilih(url) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true,
            })
            swalWithBootstrapButtons.fire({
                title: 'Apakah anda yakin?',
                text: 'Anda akan menyetujui pengajuan barang.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Iya, Setuju!',
                cancelButtonText: 'Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    let checkbox_terpilih = $("#table tbody .submission_id:checked")
                    let semua_id = []

                    $.each(checkbox_terpilih, function(index, elm) {
                        semua_id.push(elm.value)
                    });

                    $.ajax({
                        type: "post",
                        url: url,
                        data: {
                            ids: semua_id
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.status = 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            }
                            table1.ajax.reload();
                            $("#button-verifikasi-all").prop('disabled', true)
                        },
                        errors: function(errors) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Opps! Gagal',
                                text: errors.responseJSON.message,
                                showConfirmButton: true,
                            });
                            if (errors.status == 422) {
                                $('#spinner-border').hide()
                                $(button).prop('disabled', false);
                                $("#button-verifikasi-all").prop('disabled', false)

                                loopErrors(errors.responseJSON.errors);
                                return;
                            }
                        }
                    });
                }
            });
        }
    </script>
@endpush
