<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Permintaan Barang</title>

    <style>
        #orderItem {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #orderItem td,
        #orderItem th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #orderItem tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #orderItem tr:hover {
            background-color: #ddd;
        }

        #orderItem th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>

<body>
    <table class="table-bordered-none mb-3">
        <tr>
            <th>Mengajukan</th>
            <td>:</td>
            <td>
                @if (isset($user[0]))
                    {{ $user[0]->user->name }}
                @endif
            </td>
        </tr>
        <tr>
            <th>Pengajuan</th>
            <td>:</td>
            <td>
                {{-- {{ $barang->semester->name }} - {{ $barang->semester->semester }} --}}
                @if (isset($user[0]))
                    Tahun Akademik {{ $user[0]->semester->name }} -
                    {{ $user[0]->semester->semester }}
                @endif
            </td>
        </tr>
    </table>

    <table class="table table-bordered" style="width: 100%" id="orderItem">
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
            @foreach ($user as $pengajuan)
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
                    {{ format_uang($user->sum('total_price')) }}</td>
            </tr>
            <tr>
                <td colspan="7" class="text-left 2x-l text-bold">
                    {{ ucwords(terbilang($user->sum('total_price'))) }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
