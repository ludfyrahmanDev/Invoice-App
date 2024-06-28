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
                        action="{{ $data->type == 'create' ? route('supplier.store') : route('supplier.update', $data->id) }}"
                        method="POST" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        @if ($data->type != 'create')
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Nama <span class="tx-danger">*</span></label>
                                    <input type="text" {{$data->type == 'detail' ? 'disabled' :''}} id="name" name="name"
                                        class="form-control @error('name') parsley-error @enderror" placeholder="nama"
                                        value="{{ $data->name == '' ? old('name') : $data->name }}">
                                    @error('name')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Alias </label>
                                    <input type="text" {{$data->type == 'detail' ? 'disabled' :''}} id="alias" name="alias"
                                        class="form-control @error('alias') parsley-error @enderror" placeholder="alias"
                                        value="{{ $data->alias == '' ? old('alias') : $data->alias }}">
                                    @error('alias')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">No HP<span class="tx-danger">*</span></label>
                                    <input type="text" {{$data->type == 'detail' ? 'disabled' :''}} id="phone" name="phone"
                                        class="form-control @error('phone') parsley-error @enderror" placeholder="no hp"
                                        value="{{ $data->phone == '' ? old('phone') : $data->phone }}">
                                    @error('phone')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nama Bank <span class="tx-danger">*</span></label>
                                    <input type="text" {{$data->type == 'detail' ? 'disabled' :''}} id="bank" name="bank"
                                        class="form-control @error('bank') parsley-error @enderror" placeholder="nama bank"
                                        value="{{ $data->bank == '' ? old('bank') : $data->bank }}">
                                    @error('bank')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nomor Rekening <span class="tx-danger">*</span></label>
                                    <input type="text" {{$data->type == 'detail' ? 'disabled' :''}} id="account_number" name="account_number"
                                        class="form-control @error('account_number') parsley-error @enderror" placeholder="no rekening"
                                        value="{{ $data->account_number == '' ? old('account_number') : $data->account_number }}">
                                    @error('account_number')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Alamat <span class="tx-danger">*</span></label>
                                    <textarea rows="5" {{$data->type == 'detail' ? 'disabled' :''}} type="text" name="address"
                                        class="form-control @error('address') parsley-error @enderror" placeholder="address"
                                        >{{ $data->address == '' ? old('address') : $data->address }}</textarea>
                                    @error('address')
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
