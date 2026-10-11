@extends('layouts.app')

@section('content-app')
    <div class="container mt-5">
        <!-- breadcrumb -->
        <div class="row m-2">
            <fieldset>
            </fieldset>
            <form class="form-horizontal" action="{{ route('dashboard') }}" method="GET"
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
        <!-- row -->
        <div class="row row-sm justify-content-md-center">

            <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-primary-gradient">
                    <div class="ps-3 pt-3 pe-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">Pembelian Hari ini</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex flex-column">
                                <div class="">
                                    <h4 class="tx-20 fw-bold mb-1 text-white">{{ Helper::price($summary['purchase']['today']['value'] ?? '0') }}</h4>
                                </div>
                                <div class="d-flex justify-content-between text-white">
                                    <p>Kiriman: <br/><b>{{Helper::number($summary['purchase']['today']['initial'])}} KG</b></p>
                                    <p>Afkiran: <br/><b>{{Helper::number($summary['purchase']['today']['reject'])}} KG <br/>( {{Helper::percentage($summary['purchase']['today']['reject'], $summary['purchase']['today']['initial'])}} )</b></p>
                                    <p>Barang Masuk: <br/><b>{{Helper::number($summary['purchase']['today']['final'])}} KG</b></p>
                                    <p>Susut: <br/><b>{{Helper::number($summary['purchase']['today']['decrease'])}} KG</b></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-info-gradient">
                    <div class="ps-3 pt-3 pe-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">Pembelian Bulan ini</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex flex-column">
                                <div class="">
                                    <h4 class="tx-20 fw-bold mb-1 text-white">{{ Helper::price($summary['purchase']['month']['value'] ?? '0') }}</h4>
                                </div>
                                <div class="d-flex justify-content-between text-white">
                                    <p>Kiriman: <br/><b>{{Helper::number($summary['purchase']['month']['initial'])}} KG</b></p>
                                    <p>Afkiran: <br/><b>{{Helper::number($summary['purchase']['month']['reject'])}} KG <br/>({{ Helper::percentage($summary['purchase']['month']['reject'], $summary['purchase']['month']['initial']) }})</b></p>
                                    <p>Barang Masuk: <br/><b>{{Helper::number($summary['purchase']['month']['final'])}} KG</b></p>
                                    <p>Susut: <br/><b>{{Helper::number($summary['purchase']['month']['decrease'])}} KG</b></p>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-success-gradient">
                    <div class="ps-3 pt-3 pe-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">Pembelian Tahun ini</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex flex-column">
                                <div class="">
                                    <h4 class="tx-20 fw-bold mb-1 text-white">{{ Helper::price($summary['purchase']['year']['value'] ?? '0') }}</h4>
                                </div>
                                <div class="d-flex justify-content-between text-white">
                                    <p>Kiriman: <br/><b>{{Helper::number($summary['purchase']['year']['initial'])}} KG</b></p>
                                    <p>Afkiran: <br/><b>{{Helper::number($summary['purchase']['year']['reject'])}} KG <br/>({{ Helper::percentage($summary['purchase']['year']['reject'], $summary['purchase']['year']['initial']) }})</b></p>
                                    <p>Barang Masuk: <br/><b>{{Helper::number($summary['purchase']['year']['final'])}} KG</b></p>
                                    <p>Susut: <br/><b>{{Helper::number($summary['purchase']['year']['decrease'])}} KG</b></p>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-primary-gradient">
                    <div class="ps-4 pt-3 pe-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">Total Peminjaman Selesai</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 fw-bold mb-1 text-white">{{ $summary['paid']['count'] }}
                                        ({{ Helper::price($summary['paid']['total']) }})</h4>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-danger-gradient">
                    <div class="ps-3 pt-3 pe-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">Total Peminjaman Pending</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 fw-bold mb-1 text-white">{{ $summary['unpaid']['count'] }}
                                        ({{ Helper::price($summary['unpaid']['total']) }})</h4>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
