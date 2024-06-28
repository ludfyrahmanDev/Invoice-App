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

            </div>
            <div class="card-body">
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
                                <th class="wd-25p border-bottom-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->invoice_number }}</td>
                                    <td>{{ $item->supplier->name }}</td>
                                    <td>{{ $item->initial_weight }} KG</td>
                                    <td>{{ $item->reject_weight }} KG</td>
                                    <td>{{ $item->final_weight }} KG</td>
                                    <td class="d-flex">
                                        <a href="{{ route('purchase.edit', $item->id)}}" class="btn btn-sm btn-info me-2"> <i class="mdi mdi-pencil"></i>
                                            Ubah</a>
                                        <a href="{{ route('purchase.show', $item->id)}}" class="btn btn-sm btn-primary me-2"> <i class="mdi mdi-book"></i>
                                            Detail</a>
                                        <form method="POST" class="d-none" action="{{route('purchase.destroy', $item->id)}}">
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
