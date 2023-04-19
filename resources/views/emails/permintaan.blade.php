<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Surat Permohonan Pengadaan Barang</title>

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/AdminLTE/dist/css/adminlte.min.css') }}" />
</head>

<style>
    /* Kode CSS Untuk PAGE ini dibuat oleh http://jsfiddle.net/2wk6Q/1/ */
    body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #fafafa;
        font-size: 12pt;
        font-family: Arial, Helvetica, sans-serif;
    }

    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    .page {
        width: 210mm;
        min-height: 297mm;
        padding: 20mm;
        margin: 10mm auto;
        border: 1px #d3d3d3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .subpage {
        padding: 1cm;
        border: 5px red solid;
        height: 257mm;
        outline: 2cm #ffeaea solid;
    }

    @page {
        size: A4;
        margin: 0;
    }

    @media print {

        html,
        body {
            width: 210mm;
            height: 297mm;
        }

        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }

    table#styled-table {
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.9em;
        font-family: sans-serif;
        min-width: 400px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    }

    table#styled-table thead tr {
        background-color: #009879;
        color: #ffffff;
        text-align: left;
    }

    table#styled-table th,
    table#styled-table td {
        padding: 12px 15px;
    }

    table#styled-table tbody tr {
        border-bottom: 1px solid #dddddd;
    }

    table#styled-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    table#styled-table tbody tr:last-of-type {
        border-bottom: 2px solid #009879;
    }
</style>

<body>
    <div class="page">
        <table
            style="
                    width: 100%;
                    border: none;
                    border-style: hidden;
                    border-spacing: 0;
                ">
            <tr>
                <td style="width: 30px">
                    <img src="{{ asset('assets/logo/poltek.png') }}" alt="" width="70px" height="70px" />
                </td>
                <td>
                    <span id="title" style="text-align: center">
                        <span style="color: red">POLITEKNIK</span>
                        <span style="color: blue">HARAPAN BERSAMA</span>
                        <br />
                        FORM PENGAJUAN BARANG
                    </span>
                    <br />
                    <span><i>Jl. Kampus</i></span>
                </td>
            </tr>
        </table>

        <table style="width: 100%; border: none; border-style: hidden">
            <tr>
                <td>
                    <hr />
                </td>
            </tr>
        </table>

        <table style="width: 100%">
            <tr>
                <td style="text-align: right">Tegal, 10 Oktober 2023</td>
            </tr>
        </table>

        <table style="width: 100%">
            <tr>
                <td>Kepada Yth,</td>
            </tr>
            <tr height="50px">
                <td>Ka. Bagian Logistik</td>
            </tr>
            <br />
            <tr height="40px">
                <td>di Tempat</td>
            </tr>
        </table>

        <br />

        <table style="width: 100%">
            <tr>
                <td>Dengan Hormat,</td>
            </tr>
            <tr height="80px">
                <td>
                    Kami bermaksud untuk melakukan pengajuan pengadaan
                    barang untuk keperluan kami. Berikut ini adalah rincian
                    barang yang kami butuhkan:
                </td>
            </tr>
        </table>

        <table id="styled-table" style="width: 100%">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->product->satuan->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p>
            Kami harap permohonan ini dapat diproses secepatnya dan kami
            siap untuk menghadapi prosedur pengadaan barang yang ditetapkan.
        </p>
        <p>
            Demikian surat pengajuan pengadaan barang ini kami sampaikan,
            atas perhatian dan kerjasamanya kami ucapkan terima kasih
        </p>
        <br />
        <p>Hormat Kami,</p>
        <p>TTD</p>
        <p>
            @if (isset($user[0]))
                {{ $user[0]->user->name }}
            @endif
        </p>
    </div>
</body>

</html>
