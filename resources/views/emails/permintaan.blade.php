<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Surat Permohonan Pengadaan Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .btn:hover {
            background-color: #0069d9;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Surat Permohonan Pengadaan Barang</h1>
        <p>Kepada Yth.</p>
        <p>Nama Pihak yang Ditujukan</p>
        <p>Alamat Pihak yang Ditujukan</p>
        <br>
        <p>Dengan hormat,</p>
        <p>Kami bermaksud untuk melakukan pengadaan barang untuk keperluan perusahaan kami. Berikut ini adalah rincian
            barang yang kami butuhkan:</p>
        <table>
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
                        <td> {{ $loop->iteration }}</td>
                        <td> {{ $item->product->name }}</td>
                        <td> {{ $item->quantity }}</td>
                        <td> {{ $item->product->satuan->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p>Kami harap permohonan ini dapat diproses secepatnya dan kami siap untuk menghadapi prosedur pengadaan barang
            yang ditetapkan.</p>
        <p>Terima kasih atas perhatiannya.</p>
        <br>
        <p>Salam hormat,</p>
        <p>
            @if (isset($user[0]))
                {{ $user[0]->user->name }}
            @endif
        </p>
    </div>
</body>

</html>
