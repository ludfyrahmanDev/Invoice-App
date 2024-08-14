@extends('layouts.app')

@section('content-app')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-1">{{ $title }}</h4>
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

                <div class="card-body pt-0">
                    <form class="form-horizontal"
                        action="{{ $data->type == 'create' ? route('peminjaman.store') : route('peminjaman.update', $data->id) }}"
                        method="POST" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        @if ($data->type != 'create')
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Belandang <span class="tx-danger">*</span></label>
                                    <select id="supplier" name="supplier"
                                        class="form-control @error('supplier') parsley-error @enderror" placeholder="supplier">
                                        <option value="">Pilih Supplier</option>
                                        @foreach ($data->dataSupplier as $item)
                                            <option value="{{$item->id}}" {{ $data->type == 'edit' && $data->supplier == $item->id? 'selected' :'' }}>{{$item->name_alias}}</option>
                                        @endforeach
                                    </select>

                                    @error('supplier')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Jumlah<span class="tx-danger">*</span></label>
                                    <input type="number" {{$data->type == 'detail' ? 'disabled' :''}} id="quantity" name="quantity"
                                        class="form-control @error('quantity') parsley-error @enderror" placeholder="Jumlah Pinjaman"
                                        value="{{ $data->quantity == '' ? old('quantity') : $data->quantity }}">
                                    @error('quantity')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tanggal Peminjaman <span class="tx-danger">*</span></label>
                                    <input type="date" {{$data->type == 'detail' ? 'disabled' :''}} id="date" name="date"
                                        class="form-control @error('date') parsley-error @enderror" placeholder="nama date"
                                        value="{{ $data->date == '' ? old('date') : $data->date }}">
                                    @error('date')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        @if($data->type == 'detail')
                        <div class="table-responsive">
                            <table class="table table-striped" id="example1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Sub Kategori</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->subcategory as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->description }}</td>
                                        </tr>
                                    <tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                        <div class="form-group mb-0 mt-3 justify-content-end" >
                            <div>
                                @if(in_array($data->type, ['create', 'edit']))
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="reset" class="btn btn-secondary">Batal</button>
                                @endif
                                <a href="{{ route('supplier.index') }}" class="btn btn-info">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@push('script')
    <script>
        $(document).ready(function() {
            $('#name').keyup(function() {
                var name = $(this).val();
                var slug = name.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
                $('input[name="slug"]').val(slug);
            });
        });

    </script>

@endpush
@endsection
