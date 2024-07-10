@extends('layouts.app')

@section('content-app')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-1 d-flex justify-content-between">{{ $title }}
                    <a href="{{route('purchase.print', $data->id)}}" target="_blank"><button class="btn btn-primary">Cetak</button></a>
                </h4>
                @if (session('failed'))
                    <div class="alert alert-danger mg-b-0" role="alert">
                        <button aria-label="Close" class="close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('failed') }}
                    </div>
                @endif
            </div>
            <div class="card-body">
                <div class="card-body pt-0 border p-4">

                    <h4>INVOICE No. {{$data->invoice_number}}</h4>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Tanggal Transaksi: {{ $data->invoice_date }}</h5>
                        </div>
                        <div class="col-md-6 text-end">
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
                                        <td>{{ $data->invoice_date }}</td>
                                        <td>{{ $data->supplier->name }}</td>
                                        <td>{{ $data->initial_weight }}</td>
                                        <td>{{ $data->reject_weight }}</td>
                                        <td>{{ $data->final_weight }}</td>
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
                                        <td><h5>Total Keseluruhan</h5></td>
                                        <td><h5>{{ $all_qty }}</h5></td>
                                        <td class="text-end"><h5>{{ Helper::price($all_price) }}</h5></td>
                                        <td class="text-end"><h5>{{ Helper::price($all_subtotal) }}</h5></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Susut:{{$data->final_weight - $all_qty}}</h6>
                        </div>
                        <div class="col-md-6">
                            <h5>Keterangan: {{$data->description}}</h5>
                        </div>
                        <div class="col-md-6 text-center">
                            {{-- show user login --}}
                            <h5>Kasir</h5>
                            <div style="height: 50px"></div>
                            <h5>{{auth()->user()->username}}</h5>
                        </div>
                        <div class="col-md-6 text-center">
                            <h5>Belandang</h5>
                            <div style="height: 50px"></div>
                            <h5>{{$data->supplier->name}} / {{$data->supplier->alias != '' ? $data->supplier->alias : ''}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
