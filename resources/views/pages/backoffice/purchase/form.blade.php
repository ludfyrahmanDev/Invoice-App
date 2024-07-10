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
                        action="{{ $data->type == 'create' ? route('purchase.store') : route('purchase.update', $data->id) }}"
                        method="POST" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        @if ($data->type != 'create')
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Invoice Number <span class="tx-danger">*</span></label>
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" min="1" id="invoice_number" name="invoice_number"
                                            class="form-control @error('invoice_number') parsley-error @enderror" placeholder="Invoice Number"
                                            value="{{ $data->invoice_number == '' ? old('invoice_number') : $data->invoice_number }}" readonly>
                                        </div>
                                        <div class="col">
                                            <input type="text" min="1" id="invoice_code" name="invoice_code"
                                        class="form-control @error('invoice_code') parsley-error @enderror" placeholder="No Urut Bako"
                                        value="{{ $data->invoice_code == '' ? old('invoice_code') : $data->invoice_code }}">
                                        </div>
                                    </div>
                                    @error('invoice_number')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Belandang <span class="tx-danger">*</span></label>
                                    <select name="supplier_id" class="form-control select2 @error('supplier_id') parsley-error @enderror" id="supplier_id">
                                        <option value="">Pilih Belandang</option>
                                        @foreach ($suppliers as $item)
                                            <option {{$item->id == $data->supplier_id ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->name }} / {{ $item->alias}}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tanggal Transaksi <span class="tx-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <div class="input-group-text">
                                                <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control fc-datepicker" placeholder="Tanggal Transaksi" value="{{ $data->invoice_date == '' ? old('invoice_date') : $data->invoice_date }}" name="invoice_date">
                                    </div>
                                    @error('invoice_date')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Berat Awal <span class="tx-danger">*</span></label>

                                    <div class="input-group">
                                        <input type="number" min="1" id="initial_weight" name="initial_weight"
                                        class="form-control @error('initial_weight') parsley-error @enderror" placeholder="Berat Awal"
                                        value="{{ $data->initial_weight == '' ? old('initial_weight') : $data->initial_weight }}">
                                        <div class="input-group-text">
                                            <div class="input-group-text">
                                                Kg
                                            </div>
                                        </div><!-- input-group-text -->
                                    </div>
                                    @error('initial_weight')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Berat Afkir <span class="tx-danger">*</span> <b id="reject_weight_presentase">0%</b></label>

                                    <div class="input-group">
                                        <input type="number" min="1" id="reject_weight" name="reject_weight"
                                        class="form-control @error('reject_weight') parsley-error @enderror" placeholder="Berat Afkir"
                                        value="{{ $data->reject_weight == '' ? old('reject_weight') : $data->reject_weight }}">
                                        <div class="input-group-text">
                                            <div class="input-group-text">
                                                Kg
                                            </div>
                                        </div><!-- input-group-text -->
                                    </div>
                                    @error('reject_weight')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Berat Masuk <span class="tx-danger">*</span></label>

                                    <div class="input-group">
                                        <input type="number" min="1" id="final_weight" name="final_weight"
                                        class="form-control @error('final_weight') parsley-error @enderror" placeholder="Berat Masuk"
                                        value="{{ $data->final_weight == '' ? old('final_weight') : $data->final_weight }}">
                                        <div class="input-group-text">
                                            <div class="input-group-text">
                                                Kg
                                            </div>
                                        </div><!-- input-group-text -->
                                    </div>
                                    @error('final_weight')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                           <div class="col-md-12">
                            <h4>Detail Informasi Barang</h4>
                           </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Jenis Barang <span class="tx-danger">*</span></label>
                                    <select name="category_id" class="form-control select2 @error('category_id') parsley-error @enderror" id="item">
                                        <option value="">Pilih Jenis</option>
                                        @foreach ($categories as $category)
                                            <option {{$category->id == $data->category_id ? 'selected' : ''}} data-price='{{$category->purchase_price}}' value="{{ $category->id }}">{{ $category->name }}({{$category->category->name}})</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">QTY <span class="tx-danger">*</span></label>
                                    <div class="input-group">
                                        <input value="{{ $data->qty == '' ? old('qty') : $data->qty }}" class="form-control @error('qty') parsley-error @enderror" name='qty' placeholder="QTY" type="number" min="1">
                                        <div class="input-group-text">
                                            <div class="input-group-text">
                                                KG
                                            </div>
                                        </div><!-- input-group-text -->
                                    </div>
                                    @error('qty')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Harga Beli <span class="tx-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <div class="input-group-text">
                                                Rp
                                            </div>
                                        </div><!-- input-group-text -->
                                        <input value="{{ $data->selling_price == '' ? old('selling_price') : $data->selling_price }}" class="form-control @error('selling_price') parsley-error @enderror" name='selling_price' placeholder="Harga Beli" type="number">

                                    </div>
                                    @error('selling_price')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h4>Total: <b id="subtotal"></b></h4>
                            </div>
                            <div class="col-md-12 text-end">
                                <button type="button" id='addItem' class="btn btn-primary mb-4">Tambahkan</button>
                            </div>
                            <div class="col-md-12">
                                <table class="table product-item">
                                   <thead>
                                    <tr>
                                        <th>Jenis Barang</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                   </thead>
                                    <tbody>
                                        @if($data->type != 'create')
                                            @foreach ($data->purchase_detail as $item)
                                                <tr>
                                                    <td>{{$item->subcategory->name}} <input type="hidden" name="subcategory_id[]" value="{{$item->subcategory_id}}" /></td>
                                                    <td>{{$item->qty}} <input type="hidden" name="qty[]" value="{{$item->qty}}" /></td>
                                                    <td>{{Helper::price($item->price)}} <input type="hidden" name="price[]" value="{{$item->price}}" /></td>
                                                    <td>{{Helper::price($item->subtotal)}} <input type="hidden" name="subtotal[]" value="{{$item->subtotal}}" /></td>
                                                    <td><button type="button" class="btn btn-danger remove-item">Hapus</button></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Keterangan </label>
                                    <textarea rows="5" type="text" name="description"
                                        class="form-control @error('description') parsley-error @enderror" placeholder="Keterangan"
                                        >{{ $data->description == '' ? old('description') : $data->description }}</textarea>
                                    @error('description')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Pajak </label>
                                    <input type="number" min="0" id="tax" name="tax"
                                        class="form-control @error('tax') parsley-error @enderror" placeholder="Pajak"
                                        value="{{ $data->tax == '' ? old('tax') : $data->tax }}">
                                    @error('tax')
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
                                <a href="{{ route('purchase.index') }}" class="btn btn-info">Kembali</a>
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
            $('#initial_weight').change(function() {
                var val = $(this).val();
                var afkir = $('#reject_weight').val();
                calculateAfkir(val, afkir);
            });
            calculateAfkir($('#initial_weight').val(), $('#reject_weight').val());
            $('#reject_weight').change(function() {
                var val = $(this).val();
                var initial = $('#initial_weight').val();
                calculateAfkir(initial, val);
            });
            function calculateAfkir(initial,reject){
                // calculate presentase reject from initial
                if(parseInt(reject) > parseInt(initial)){
                    alert('Berat Afkir tidak boleh lebih besar dari Berat Awal');
                    $('#reject_weight').val('');
                    return;
                }
                var result = (reject / initial) * 100;
                // get 2 decimal
                result = result.toFixed(2);
                $('#reject_weight_presentase').text(result+'%');
                // final weight
                var final = initial - reject;
                $('#final_weight').val(final);
            }


            // form product
            $('#item').change(function(){
                var price = $(this).find(':selected').data('price');
                $('input[name="selling_price"]').val(price);
                calculateSubtotal();
            });
            // on selling price change
            $('input[name="selling_price"]').change(function(){
                calculateSubtotal();
            });
            // on qty change
            $('input[name="qty"]').change(function(){
                calculateSubtotal();
            });
            function calculateSubtotal(){
                var qty = $('input[name="qty"]').val();
                var price = $('input[name="selling_price"]').val();
                var total = qty * price;
                // set number format
                total = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total);
                $('#subtotal').text(total);
            }

            // add item to list
            $('#addItem').click(function(){
                var item = $('#item').find(':selected').text();
                // get item value
                var item_value = $('#item').val();
                // check if same item already added
                var exists = false;
                $('.product-item tbody tr').each(function(){
                    var current_item = $(this).find('input[name="subcategory_id[]"]').val();
                    if(current_item == item_value){
                        exists = true;
                    }
                });
                if(exists){
                    alert('Item sudah ada di list');
                    return;
                }
                var price = $('input[name="selling_price"]').val();
                var qty = $('input[name="qty"]').val();
                var subtotal = qty * price;
                var html = '<tr>';
                html += '<td>'+item+' <input type="hidden" name="subcategory_id[]" value="'+item_value+'" /></td>';
                html += '<td>'+qty+' <input type="hidden" name="qty[]" value="'+qty+'" /></td>';
                html += '<td>'+formatRupiah(price)+' <input type="hidden" name="price[]" value="'+price+'" /></td>';
                html += '<td>'+formatRupiah(subtotal)+' <input type="hidden" name="subtotal[]" value="'+subtotal+'" /></td>';
                // add remove button
                html += '<td><button type="button" class="btn btn-danger remove-item">Hapus</button></td>';
                html += '</tr>';
                $('.product-item tbody').append(html);
            });

            $('.product-item').on('click','.remove-item',function(){
                $(this).closest('tr').remove();
            });
        });

    </script>

@endpush
@endsection
