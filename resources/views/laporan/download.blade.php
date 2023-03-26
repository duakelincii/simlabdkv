<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>

<body>
    <h1 style="align-items:center;text-transform: uppercase;">{{ $jenis }}</h1>
    @if ($jenis == 'barang masuk' || $jenis == 'barang keluar')
        <table border="1" width="100%" cellpadding="10">
            <tr>
                <th>Barang</th>
                <th>From</th>
                <th>Keterangan</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
            @foreach ($barangs as $data)
                <tr>
                    <td>{{ $data->barang->name }}</td>
                    <td>{{ $data->from }}</td>
                    <td>{{ $data->keterangan }}</td>
                    <td>{{ $data->total }}</td>
                    <td>{{ localDate($data->created_at) }}</td>
                </tr>
            @endforeach
        </table>
    @elseif ($jenis == 'peminjaman')
        <table border="1" width="100%" cellpadding="10">
            <tr>
                <th>Member</th>
                <th>Barang</th>
                <th>Qty</th>
                <th>Return</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
            @foreach ($loans as $loan)
                @foreach ($loan->barangs as $barang)
                    <tr>
                        <td>{{ $loan->member->name }}</td>
                        <td>{{ $barang->name }}</td>
                        <td>{{ $loan->pivot->qty }}</td>
                        <td>{{ $loan->return }}</td>
                        <td>{{ $loan->status }}</td>
                        <td>{{ localDate($loan->created_at) }}</td>
                    </tr>
                @endforeach
            @endforeach
        </table>
    @endif
</body>

</html>
