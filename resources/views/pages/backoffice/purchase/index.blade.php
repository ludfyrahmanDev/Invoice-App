@extends('layouts.app')

@section('content-app')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">{{$title}}</h4>
                    <a href="{{ route('purchase.create') }}" class="btn btn-sm btn-primary"><i class="mdi mdi-plus"></i> Tambah
                        </a>

                </div>
                <p class="tx-12 tx-gray-500 mb-2">Data </p>
                @if (session('success'))
                    <div class="alert alert-success mg-b-0" role="alert">
                        <button aria-label="Close" class="close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('success') }}
                    </div>
                @endif
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
                <div class="row m-2">
                    <fieldset>
                        <legend>Filter</legend>
                    </fieldset>
                    <form class="form-horizontal" action="{{ route('purchase.index') }}" method="GET"
                        enctype="multipart/form-data" data-parsley-validate="">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="">Tanggal Transaksi</label>
                                    <div class="row no-gutters">
                                        <div class="col-md-6">
                                            <input type="date" class="form-control" placeholder="Start Date" value="{{ $start_Date }}" name="start_date">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="date" class="form-control" placeholder="End Date" value="{{ $end_Date }}" name="end_date">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-sm btn-success " style="margin-top: 30px !important;"
                                    type="submit"><i class="mdi mdi-filter"></i> Filter</button>
                            
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">No</th>
                                <th class="wd-15p border-bottom-0">Nomor Invoice</th>
                                <th class="wd-15p border-bottom-0">Supplier</th>
                                <th class="wd-15p border-bottom-0">Berat Awal</th>
                                <th class="wd-15p border-bottom-0">Berat Afkiran</th>
                                <th class="wd-15p border-bottom-0">Berat Masuk</th>
                                <th class="wd-15p border-bottom-0">Status</th>
                                <th class="wd-25p border-bottom-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->invoice_number }}</td>
                                    <td>{{ $item->supplier->name_alias }}</td>
                                    <td>{{ $item->initial_weight }} KG</td>
                                    <td>{{ $item->reject_weight }} KG</td>
                                    <td>{{ $item->final_weight }} KG</td>
                                    <td>
                                        @if ($item->phase == 'draft')
                                            <span class="badge bg-warning text-white">Draft</span>
                                        @else
                                            <span class="badge bg-success text-white">Publish</span>
                                        @endif
                                    </td>
                                    <td class="d-flex">
                                        <a href="{{ route('purchase.edit', $item->id)}}" class="btn btn-sm btn-info me-2"> <i class="mdi mdi-pencil"></i>
                                            Ubah</a>
                                        <a href="{{ route('purchase.show', $item->id)}}" class="btn btn-sm btn-primary me-2"> <i class="mdi mdi-book"></i>
                                            Detail</a>
                                        <form method="POST" action="{{route('purchase.destroy', $item->id)}}">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" onclick="return confirm('apakah anda yakin ingin menghapus data ??')" class="btn btn-sm btn-danger"><i class="mdi mdi-delete"></i>
                                            Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
