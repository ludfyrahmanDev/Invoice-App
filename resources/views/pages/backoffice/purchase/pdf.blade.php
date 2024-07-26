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
    <div class="row mt-4">
        <div class="col-md-6">
            <h4 class="text-start">INVOICE No. {{$data->invoice_number}}</h4>
            <h5>Periode: {{ date('d-M-Y', strtotime($data->invoice_date)) }}</h5>
        </div>
        <div class="col-md-6 text-end" style="float:right;margin-top:-70px">
            <h5>User: {{ auth()->user()->username }}</h5>
            <h5>Tanggal: {{ date('d-M-Y') }}</h5>
            <h2>% AFKIRAN: {{ $data->reject_weight_presentase }}%</h2>
        </div>
        <div class="col-md-12">
            <table class="table mt-2">
                <thead>
                    <th>Tanggal</th>
                    <th>Nama Belandang</th>
                    <th>Berat Awal</th>
                    <th>Berat Afkir</th>
                    <th>Berat Masuk</th>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ date('d-M-Y', strtotime($data->invoice_date)) }}</td>
                        <td>{{ $data->supplier->name_alias }}</td>
                        <td class="text-center">{{ $data->initial_weight }}</td>
                        <td class="text-center">{{ $data->reject_weight }}</td>
                        <td class="text-center">{{ $data->final_weight }}</td>
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
                            <tr>
                                <td class="text-center">{{ $childItem->subcategory->name }}</td>
                                <td>{{ $childItem->qty }}</td>
                                <td class="text-end">{{ Helper::price($childItem->price) }}</td>
                                <td class="text-end">{{ Helper::price($childItem->subtotal) }}</td>
                            </tr>
                        @endforeach
                        <tr class="border">
                            <td><b>Total {{$key}}</b></td>
                            <td ><b>{{$qty}}</b></td>
                            <td class="text-end"><b>{{Helper::price($price)}}</b></td>
                            <td class="text-end"><b>{{Helper::price($subtotal)}}</b></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td><b>Total Keseluruhan</b></td>
                        <td><b>{{ $all_qty }}</b></td>
                        <td class="text-end"><b>{{ Helper::price($all_price) }}</b></td>
                        <td class="text-end"><b>{{ Helper::price($all_subtotal) }}</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-md-6">
            <h2>Susut:{{$data->final_weight - $all_qty}}</h2>
        </div>
        <div class="col-md-6">
            <h5>Keterangan: {{$data->description}}</h5>
        </div>
        <div style="margin-top: 8px">
            <div class="col-md-6 text-center left">
                {{-- show user login --}}
                <h5>Kasir</h5>
                <div style="height: 30px"></div>
                <h5>{{auth()->user()->username}}</h5>
            </div>
            <div class="col-md-6 text-center right">
                <h5>Belandang</h5>
                <div style="height: 30px"></div>
                <h5>{{$data->supplier->name_alias}} </h5>
            </div>
        </div>
    </div>
</body>
</html>
