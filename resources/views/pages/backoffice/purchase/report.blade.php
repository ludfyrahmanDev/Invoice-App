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
                    <a href="{{route('purchase.allPrint', ['date' => $request->start_date, 'supplier_id' => $supplier_id])}}" target="_blank"><button class="btn btn-primary">Cetak</button></a>
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
                                <label for="">Jenis Laporan</label>
                                <select name="report_type" class="form-control select2 @error('report_type') parsley-error @enderror" id="">
                                    @php
                                        $report_type = $request->report_type;
                                    @endphp
                                    <option value="">Pilih Jenis Laporan</option>
                                    <option value="head_supplier" {{'head_supplier' == $request->report_type ? 'selected' : ''}}>Kepala Belandang</option>
                                    <option value="supplier" {{'supplier' == $request->report_type ? 'selected' : ''}}>Belandang</option>
                                    <option value="mutu" {{'mutu' == $request->report_type ? 'selected' : ''}}>Mutu</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4" id="category_id">
                                <label for="">Mutu</label>
                                <select name="category_id" class="form-control select2 @error('category_id') parsley-error @enderror" id="">
                                    <option value="">Pilih Mutu</option>
                                    @foreach ($category as $item)
                                        <option {{$item->id == $request->category_id ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4" id="head_supplier_id">
                                <label for="">Kepala Belandang</label>
                                <select name="head_supplier_id" class="form-control select2 @error('head_supplier_id') parsley-error @enderror" id="">
                                    <option value="">Pilih Belandang</option>
                                    @foreach ($head_supplier as $item)
                                        <option {{$item->id == $request->head_supplier_id ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->name_alias }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4" id="supplier_id">
                                <label for="">Belandang</label>
                                <select name="supplier_id" class="form-control select2 @error('supplier_id') parsley-error @enderror" id="">
                                    <option value="">Pilih Belandang</option>
                                    @foreach ($suppliers as $item)
                                        <option {{$item->id == $request->supplier_id ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->name_alias }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Tanggal</label>
                                <div class="row no-gutters">
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" placeholder="Start Date" value="{{ $request->start_date == '' ? old('start_date') : $request->start_date }}" name="start_date">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" placeholder="End Date" value="{{ $request->end_date == '' ? old('end_date') : $request->end_date }}" name="end_date">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-12 text-center">
                                <input type="submit" name="search" class="btn btn-primary" value="Cari">
                                <input type="reset" name="search" class="btn btn-secondary" value="Reset" onclick="window.location.reload()">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script>
            $("#supplier_id").hide();
            $("#category_id").hide();
            // on change report type
            $('select[name="report_type"]').on('change', function(){
                let report_type = $(this).val();
                if(report_type == 'supplier'){
                    // hide category
                    $("#supplier_id").show();
                    $('select[name="category_id"]').val('');
                    $('select[name="head_supplier_id"]').val('');
                    $('#category_id').hide();
                    $('#head_supplier_id').hide();

                }else if(report_type == 'mutu'){
                    $('#supplier_id').hide();
                    $('#head_supplier_id').hide();
                    $("#category_id").show();
                    // clear value select category_id
                    $('select[name="supplier_id"]').val('');
                    $('select[name="head_supplier_id"]').val('');
                }else{
                    $('#head_supplier_id').show();
                    $('#supplier_id').hide();
                    $('#category_id').hide();
                }
            });
        </script>
    @endpush
@endsection
