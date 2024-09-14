<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
    table td{
        padding: 8px;
    }

    table, th {
        border: 1px solid #777;
        border-collapse: collapse;
    }
    body{
        font-size: 14px;
    }
    .left {
        float: left;
    }
    .right {
        float: right;
    }
</style>
<body>
    {{-- include header --}}
    {{-- @include('pages.backoffice.purchase.header') --}}
    <h2>Nota Pembayaran</h2>
    <div class="row mt-4">
        <div class="col-md-6">
        </div>
        <div class="col-md-6 text-end" style="float:right;margin-top:-70px">
            <h5>Tanggal Transaksi: {{ date('Y-m-d') }}</h5>
        </div>
        @php
            $all_qty = 0;
            $all_price = 0;
            $all_subtotal = 0;
        @endphp
        @foreach ($data->detail as $key => $item)
            @php
                $qty = 0;
                $price = 0;
                $subtotal = 0;
            @endphp
            @foreach ($item as $childItem)
                @php
                    $qty += $childItem->qty;
                    $price += $childItem->price;
                    $subtotal += $childItem->subtotal;
                    $all_qty += $childItem->qty;
                    $all_price += $childItem->price;
                    $all_subtotal += $childItem->subtotal;
                @endphp

            @endforeach
        @endforeach
        <div class="col-md-12">
            <table class="table mt-2">
                <tr>
                    <td>Nama Belandang</td><td>:</td><td>{{ $data->supplier?->name_alias }}</td>
                </tr>
                <tr>
                    <td>No Invoice</td><td>:</td><td> {{$data->invoice_number}}</td>
                </tr>
                <tr>
                    <td>Berat Masuk</td><td>:</td><td>{{ $data->final_weight }}</td>
                </tr>
                <tr>
                    <td>Total Harga</td><td>:</td><td>{{Helper::price($all_subtotal)}}</td>
                </tr>
            </table>

        </div>
        <div class="col-md-6">
            <h5>Keterangan: {{$data->description}}</h5>
        </div>
        <div style="margin-top: 8px">
            <div class="col-md-6 text-center left">

            </div>
            <div class="col-md-6 text-center right">
                <h5>Penerima</h5>
                <div style="height: 30px"></div>
                <h5>............................... </h5>
            </div>
        </div>
    </div>
</body>
</html>
