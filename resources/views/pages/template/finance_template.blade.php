<!DOCTYPE html>
<html>

<head>
    <title>Laporan Keuangan CV.ITA SOLUSI</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <center>
        <h4>Laporan Keuangan CV.ITA SOLUSI</h4>
        <h6 class="mb-4"> {{ Helper::tanggal($start) }} - {{ Helper::tanggal($end) }}
        </h6>
    </center>

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th style="text-align:center" width="10">No</th>
                <th style="text-align:center" width="90">Kode</th>
                <th style="text-align:center" width="110">Tanggal</th>
                <th style="text-align:center">Tipe Transaksi</th>
                <th style="text-align:center">Jenis Transaksi</th>
                <th style="text-align:center">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach ($data as $item)
                <tr>
                    <td width="10">{{ $i++ }}</td>
                    <td width="90">{{ $item->invoice }}</td>
                    <td width="110">{{ Helper::tanggal($item->tanggal) }}</td>
                    <td>{{ $item->tipe_transaksi }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td>{{ Helper::rupiah($item->total) }}</td>
                </tr>
            @endforeach

        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                    <span>Total Pembelian</span>
                </td>
                <td>
                    <span><strong>{{ Helper::rupiah($pembelian) }}</strong></span>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <span>Total Penjualan</span>
                </td>
                <td>
                    <span><strong>{{ Helper::rupiah($penjualan) }}</strong></span>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <span>Total Keuntungan</span>
                </td>
                <td>
                    <span><strong>{{ Helper::rupiah($laba) }}</strong></span>
                </td>
            </tr>
        </tfoot>
    </table>




</body>

</html>
