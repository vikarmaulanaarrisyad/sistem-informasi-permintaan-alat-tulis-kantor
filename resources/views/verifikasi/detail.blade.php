@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"> <a href="{{ route('verifikasi-permintaan.index') }}">Pengajuan</a></li>
    <li class="breadcrumb-item active">Detail Pengajuan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-card>
                <x-slot name="header">
                    <a href="{{ route('verifikasi-permintaan.index') }}" class="btn btn-sm btn-primary"><i
                            class="fas fa-arrow-circle-left"></i> Kembali</a>
                </x-slot>

                <table class="table-bordered-none mb-3">
                    <tr>
                        <th>Mengajukan</th>
                        <td>:</td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Pengajuan</th>
                        <td>:</td>
                        <td>
                            {{-- {{ $barang->semester->name }} - {{ $barang->semester->semester }} --}}
                            @if (isset($pengajuanBarang[0]))
                              Tahun Akademik {{ $pengajuanBarang[0]->semester->name }} - {{ $pengajuanBarang[0]->semester->semester }}
                            @endif
                        </td>
                    </tr>
                </table>

                <table class="table table-bordered" style="width: 100%">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Harga Satuan</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengajuanBarang as $pengajuan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pengajuan->product->code }}</td>
                                <td>{{ $pengajuan->product->name }}</td>
                                <td class="text-center">{{ $pengajuan->quantity }}</td>
                                <td class="text-center">{{ $pengajuan->product->satuan->name }}</td>
                                <td class="text-right">{{ format_uang($pengajuan->product->price) }}</td>
                                <td class="text-right"> {{ format_uang($pengajuan->total_price) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="6" class="text-right text-bold">Total</td>
                            <td colspan="1" class="text-right text-bold">
                                {{ format_uang($pengajuanBarang->sum('total_price')) }}</td>
                        </tr>
                        <tr>
                            <td colspan="7" class="text-left 2x-l text-bold">{{ ucwords( terbilang($pengajuanBarang->sum('total_price'))) }}</td>
                        </tr>
                    </tbody>
                </table>

            </x-card>
        </div>
    </div>
@endsection
