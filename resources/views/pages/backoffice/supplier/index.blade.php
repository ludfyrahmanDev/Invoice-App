@extends('layouts.app')

@section('content-app')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">{{$title}}</h4>
                    <a href="{{ route('supplier.create') }}" class="btn btn-sm btn-primary"><i class="mdi mdi-plus"></i> Tambah
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
                                <th class="wd-20p border-bottom-0">Nama</th>
                                <th class="wd-20p border-bottom-0">Alamat</th>
                                <th class="wd-25p border-bottom-0">Telepon</th>
                                <th class="wd-25p border-bottom-0">Bank</th>
                                <th class="wd-25p border-bottom-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }} <br> @if($item->alias != '')({{$item->alias}}) @endif</td>
                                    <td>{{ $item->address }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->bank }} - {{ $item->account_number }}</td>
                                    <td class="d-flex">
                                        <a href="{{ route('supplier.edit', $item->id)}}" class="btn btn-sm btn-info me-2"> <i class="mdi mdi-pencil"></i>
                                            Ubah</a>
                                        {{-- @if($item->subcategory->count() == 0) --}}
                                            <form action="{{ route('supplier.destroy', $item->id) }}" method="POST" onclick="return confirm('apakah anda yakin ingin menghapus data ini??')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"> <i class="mdi mdi-delete"></i>
                                                    Hapus</button>
                                            </form>
                                        {{-- @endif --}}

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