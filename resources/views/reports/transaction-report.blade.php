<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Transaction Report</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <!-- Styles -->

    <style>
        * {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>
    <div class="">
        <h2 class="">Laporan Transaksi</h2>

        <table style="width: 100%;">
            <thead>
                <tr style="background: black; color: white; padding: 10px">
                    <th style="text-align: left; vertical-align: middle; padding: 10px">Id</th>
                    <th style="text-align: left; vertical-align: middle; padding: 10px">Tanggal Transaksi</th>
                    <th style="text-align: left; vertical-align: middle; padding: 10px">Nama Kasir</th>
                    <th style="text-align: left; vertical-align: middle; padding: 10px">Nama Customer</th>
                    <th style="text-align: left; vertical-align: middle; padding: 10px">Total</th>
                    <th style="text-align: left; vertical-align: middle; padding: 10px">Bayar</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($datas as $data)
                <tr>
                    <td style="padding-left: 10px;">{{ $data->id }}</td>
                    <td style="padding-left: 10px;">{{ $data->created_at->format('d-m-Y') }}</td>
                    <td style="padding-left: 10px;">{{ $data->user?->username }}</td>
                    <td style="padding-left: 10px;">{{ $data->customer_name }}</td>
                    <td style="padding-left: 10px;">{{ formatRupiah($data->total) }}</td>
                    <td style="padding-left: 10px;">{{ formatRupiah($data->payment) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 30px; margin-left: auto; width: 100%">
            <div style="text-align: right;">Kamis, 21 Agustus 2003</div>
            <div style="text-align: right; margin-bottom: 100px; padding-right: 43px">Mengetahui</div>

            <div style="text-align: right; padding-right: 50px">Manager</div>
        </div>
    </div>
</body>

</html>
