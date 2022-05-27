<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sales Report</title>

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
        <h2 class="">Laporan Pendapatan</h2>

        <table style="width: 100%;">
            <thead>
                <tr style="background: black; color: white; padding: 10px">
                    <th style="text-align: left; vertical-align: middle; padding: 10px">Id</th>
                    <th style="text-align: left; vertical-align: middle; padding: 10px">Tanggal Transaksi</th>
                    <th style="text-align: left; vertical-align: middle; padding: 10px">Total</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($datas as $data)
                <tr>
                    <td style="padding-left: 10px;">{{ $data->id }}</td>
                    <td style="padding-left: 10px;">{{ $data->created_at->format('d-m-Y') }}</td>
                    <td style="padding-left: 10px;">{{ formatRupiah($data->total) }}</td>
                </tr>
                @endforeach
                <tr style="background: black; color: white; padding: 10px">
                    <td colspan="2" style="text-align: left; vertical-align: middle; padding: 10px">Total Pendapatan</td>
                    <td style="text-align: left; vertical-align: middle; padding: 10px">{{ formatRupiah($total) }}</td>
                </tr>
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
