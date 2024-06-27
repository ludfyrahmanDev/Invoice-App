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
                        action="{{ $data->type == 'create' ? route('sub_category.store') : route('sub_category.update', $data->id) }}"
                        method="POST" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        @if ($data->type != 'create')
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Kategori <span class="tx-danger">*</span></label>
                                    <select name="category_id" class="form-control select2 @error('category_id') parsley-error @enderror" id="">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option {{$category->id == $data->category_id ? 'selected' : ''}} value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Sub Kategori / Jenis <span class="tx-danger">*</span></label>
                                    <input type="text" id="name" name="name"
                                        class="form-control @error('name') parsley-error @enderror" placeholder="kategori"
                                        value="{{ $data->name == '' ? old('name') : $data->name }}">
                                    @error('name')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Harga Beli <span class="tx-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <div class="input-group-text">
                                                Rp
                                            </div>
                                        </div><!-- input-group-text -->
                                        <input value="{{ $data->purchase_price == '' ? old('purchase_price') : $data->purchase_price }}" class="form-control @error('purchase_price') parsley-error @enderror" name='purchase_price' placeholder="Harga Beli" type="text">
                                    </div>
                                    @error('purchase_price')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Harga Jual <span class="tx-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <div class="input-group-text">
                                                Rp
                                            </div>
                                        </div><!-- input-group-text -->
                                        <input value="{{ $data->selling_price == '' ? old('selling_price') : $data->selling_price }}" class="form-control @error('selling_price') parsley-error @enderror" name='selling_price' placeholder="Harga Jual" type="text">

                                    </div>
                                    @error('selling_price')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Deskripsi </label>
                                    <textarea rows="5" type="text" name="description"
                                        class="form-control @error('description') parsley-error @enderror" placeholder="description"
                                        >{{ $data->description == '' ? old('description') : $data->description }}</textarea>
                                    @error('description')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>


                        </div>
                        <div class="form-group mb-0 mt-3 justify-content-end">
                            <div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn btn-secondary">Batal</button>
                                <a href="{{ route('sub_category.index') }}" class="btn btn-info">Kembali</a>
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
