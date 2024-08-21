@extends('layouts.app')

@section('content-app')
    <div class="container mt-5">
        <!-- breadcrumb -->

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
                                    <p>Afkiran: <br/><b>{{Helper::number($summary['purchase']['today']['reject'])}} KG</b></p>
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
                                    <p>Afkiran: <br/><b>{{Helper::number($summary['purchase']['month']['reject'])}} KG</b></p>
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
                                    <p>Afkiran: <br/><b>{{Helper::number($summary['purchase']['year']['reject'])}} KG</b></p>
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
