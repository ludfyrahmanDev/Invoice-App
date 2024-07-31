<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Supplier</title>
</head>
<style>
    .col-md-6 {
        width: 50%;
    }
    .col-md-12 {
        width: 100%;
    }
    .text-end {
        text-align: right;
    }
    .text-start {
        text-align: start;
    }
    .text-center {
        text-align: center;
    }
    .border {
        border-top: 1px solid #000;
    }

    h5,h6,h4 {
        margin: 0;
    }
    table {
        width: 100%;
    }

    table, th,td {
        border: 1px solid #dddd;
        border-collapse: collapse;
        padding: 8px;
    }
    body{
        font-size: 12px;
    }
    .left {
        float: left;
    }
    .right {
        float: right;
    }
    .text-right {
        text-align: right;
    }
</style>
<body>
    @include('pages.backoffice.purchase.header')
    <div class="col-md-6">
        <h3>Lap Pembelian: {{ $request->supplier_id ? $supplier->name_alias : ($request->head_supplier_id ? 'Laporan Belandang:'.$supplier->name_alias: 'Seluruh Belandang') }}</h3>
    </div>
    <div class="col-md-6 text-end right" style="margin-top:-70px">
        <h5>Tanggal: {{ date('d-M-Y') }}</h5>
    </div>
    @if ($request->start_date && $request->end_date)
        <div class="col-md-12">
            <h5>Periode: {{ $request->start_date }} - {{ $request->end_date }}</h5>
        </div>
    @endif
    <table>
        <thead>
            <tr>
                <th>Jenis</th>
                <th>Berat</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['data'] as $item)
                <tr>
                    <td class="text-center">{{ $item->name }}</td>
                    <td class="text-center">{{ $item->qty }} Kg</td>
                    <td class="text-right">{{ Helper::price($item->price) }}</td>
                    <td class="text-right">{{ Helper::price($item->subtotal) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td class="text-center">Total</td>
                <td class="text-center">{{ $data['qty'] }} Kg</td>
                <td class="text-right">{{ Helper::price($data['subtotal'] / $data['qty']) }}</td>
                <td class="text-right">{{ Helper::price($data['subtotal']) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
