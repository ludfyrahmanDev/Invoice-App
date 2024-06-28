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

    table, th {
        border: 1px solid #dddd;
        border-collapse: collapse;
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
</style>
<body>
    <h4>INVOICE No. {{$date}}</h4>
    <div class="row mt-4">
        <div class="col-md-6">
            <h5>Tanggal Transaksi: {{ $date }}</h5>
        </div>
        <div class="col-md-6 text-end right" style="margin-top:-40px">
            <h5>User: {{ auth()->user()->username }}</h5>
            <h5>Tanggal: {{ date('d-M-Y') }}</h5>
            <h5>% AFKIRAN: {{ $reject_weight_presentase }}%</h5>
        </div>
        @php
        $all_qty = 0;
        $all_price = 0;
        $all_subtotal = 0;
        $all_final = 0;
                    @endphp
        @foreach ($data as $key => $parentItem)
        <div class="col-md-12" >
            <table class="table mt-2">
                @if($key == 0)
                <thead>
                    <th>Tanggal</th>
                    <th>Nama Belandang</th>
                    <th>Berat Awal</th>
                    <th>Berat Afkir</th>
                    <th>Berat Masuk</th>
                </thead>
                @endif
                @php
                    $all_final +=$parentItem->final_weight;
                @endphp
                <tbody>
                    <tr>
                        <td style="width: 20%">{{ $parentItem->invoice_date }}</td>
                        <td style="width: 20%">{{ $parentItem->supplier->name }}</td>
                        <td style="width: 20%">{{ $parentItem->initial_weight }}</td>
                        <td style="width: 20%">{{ $parentItem->reject_weight }}</td>
                        <td style="width: 20%">{{ $parentItem->final_weight }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table">

                <thead>
                    <th class="text-center">Jenis</th>
                    <th>Berat</th>
                    <th class="text-end">Harga</th>
                    <th class="text-end">Subtotal</th>
                </thead>
                <tbody>

                    @foreach ($parentItem->detail as $key => $item)
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
                            <tr>
                                <td class="text-center">{{ $childItem->subcategory->name }}</td>
                                <td>{{ $childItem->qty }}</td>
                                <td class="text-end">{{ Helper::price($childItem->price) }}</td>
                                <td class="text-end">{{ Helper::price($childItem->subtotal) }}</td>
                            </tr>
                        @endforeach
                        <tr class="border">
                            <td class="text-center"><b>Total {{$key}}</b></td>
                            <td ><b>{{$qty}}</b></td>
                            <td class="text-end"><b>{{Helper::price($price)}}</b></td>
                            <td class="text-end"><b>{{Helper::price($subtotal)}}</b></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @endforeach
        <table>
            <tfoot>
                <td><h5>Total Keseluruhan</h5></td>
                <td><h5>{{ $all_qty }}</h5></td>
                <td class="text-end"><h5>{{ Helper::price($all_price) }}</h5></td>
                <td class="text-end"><h5>{{ Helper::price($all_subtotal) }}</h5></td>
            </tfoot>
        </table>

        <div class="col-md-6">
            <h6>Susut:{{$all_final - $all_qty ?? 0}}</h6>
        </div>
        <div class="col-md-6 text-center left">
            <h5>Kasir</h5>
            <div style="height: 50px"></div>
            <h5>{{auth()->user()->username}}</h5>
        </div>
        <div class="col-md-6 text-center right">
            <h5>Belandang</h5>
            <div style="height: 50px"></div>
            <h5>{{$supplier->name}} / {{$supplier->alias != '' ? $supplier->alias : ''}}</h5>
        </div>
    </div>
</body>
</html>
