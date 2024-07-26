@extends('layouts.app')

@section('content-app')
<style>
    th{
        text-align: left!important;
    }
</style>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-1 d-flex justify-content-between">{{ $title }}
                    {{-- <a href="{{route('purchase.allPrint', ['date' => $filter_date, 'supplier_id' => $supplier_id])}}" target="_blank"><button class="btn btn-primary">Cetak</button></a> --}}
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
                    <form action="" method="get">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="">Belandang</label>
                                <select name="supplier_id" class="form-control select2 @error('supplier_id') parsley-error @enderror" id="">
                                    <option value="">Pilih Belandang</option>
                                    @foreach ($suppliers as $item)
                                        <option {{$item->id == $request->supplier_id ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Tanggal</label>
                                <div class="row no-gutters">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control fc-datepicker" placeholder="Start Date" value="{{ $request->start_date == '' ? old('start_date') : $request->start_date }}" name="start_date">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control fc-datepicker" placeholder="End Date" value="{{ $request->end_date == '' ? old('end_date') : $request->end_date }}" name="end_date">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Mutu</label>
                                <select name="category_id" class="form-control select2 @error('category_id') parsley-error @enderror" id="">
                                    <option value="">Pilih Mutu</option>
                                    @foreach ($category as $item)
                                        <option {{$item->id == $request->category_id ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-12 text-center">
                                <input type="submit" class="btn btn-primary" value="Cari">
                            </div>
                        </div>
                    </form>
                    @if($supplier_id)
                        {{-- <h4>INVOICE No. {{$date}}</h4> --}}
                        <div class="row mt-4">
                            <div class="col-md-6">
                                {{-- <h5>Tanggal Transaksi: {{ $date }}</h5> --}}
                            </div>
                            <div class="col-md-6 text-end">
                                <h2>% AFKIRAN: {{ $reject_weight_presentase }}%</h2>
                            </div>
                            @foreach ($data as $parentItem)
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
                                            <td>{{ $parentItem->invoice_date }}</td>
                                            <td>{{ $parentItem->supplier->name_alias }}</td>
                                            <td>{{ $parentItem->initial_weight }}</td>
                                            <td>{{ $parentItem->reject_weight }}</td>
                                            <td>{{ $parentItem->final_weight }}</td>
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
                                                    <td >{{ $childItem->subcategory->name }}</td>
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
                                    {{-- <tfoot>
                                        <tr>
                                            <td><h5>Total Keseluruhan</h5></td>
                                            <td><h5>{{ $all_qty }}</h5></td>
                                            <td class="text-end"><h5>{{ Helper::price($all_price) }}</h5></td>
                                            <td class="text-end"><h5>{{ Helper::price($all_subtotal) }}</h5></td>
                                        </tr>
                                    </tfoot> --}}
                                </table>
                            </div>
                            {{-- <div class="col-md-6">
                                <h6>Susut:{{$parentItem->final_weight - $all_qty}}</h6>
                            </div>
                            <div class="col-md-6">
                                <h5>Keterangan: {{$parentItem->description}}</h5>
                            </div> --}}
                            {{-- <div class="col-md-6 text-center">
                                <h5>Kasir</h5>
                                <div style="height: 50px"></div>
                                <h5>{{auth()->user()->username}}</h5>
                            </div>
                            <div class="col-md-6 text-center">
                                <h5>Belandang</h5>
                                <div style="height: 50px"></div>
                                <h5>{{$parentItem->supplier->name}} / {{$parentItem->supplier->alias != '' ? $parentItem->supplier->alias : ''}}</h5>
                            </div> --}}
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
