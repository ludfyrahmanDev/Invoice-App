<!DOCTYPE html>
<html>

<head>
    <title>Laporan Stok Barang CV.ITA SOLUSI</title>
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
        <h4>Laporan Stok Barang CV.ITA SOLUSI</h4>
        
    </center>

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th style="text-align:center" width="10">No</th>
                <th style="text-align:center" width="110">Kode</th>
                <th style="text-align:center" width="150">Nama Barang</th>
                <th style="text-align:center" width="90">Satuan</th>
                <th style="text-align:center" width="100">Stok</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach ($data as $item)
                <tr>
                    <td width="10">{{ $i++ }}</td>
                    <td style="text-align:center" width="110">{{ $item->kode }}</td>
                    <td width="150">{{ $item->nama }}</td>
                    <td style="text-align:center" width="90">{{ $item->akronim }}</td>
                    <td style="text-align:center" width="100">{{ $item->stok }}</td>
                </tr>
            @endforeach

        </tbody>
       
    </table>




</body>

</html>
