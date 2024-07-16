@extends('layouts.app')

@section('content-app')
    <div class="container mt-4">

        <div class="row">
            <div class="col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-primary-gradient">
                    <div class="ps-3 pt-3 pe-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">Total Peminjaman Selesai</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 fw-bold mb-1 text-white">{{ $summary['paid'] }}</h4>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-danger-gradient">
                    <div class="ps-3 pt-3 pe-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">Total Peminjaman Pending</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 fw-bold mb-1 text-white">{{ $summary['unpaid'] }}
                                    </h4>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">{{ $title }}</h4>
                    <a href="{{ route('peminjaman.create') }}" class="btn btn-sm btn-primary"><i class="mdi mdi-plus"></i>
                        Tambah
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
                <div class="alert alert-success mg-b-0 d-none" id="successApprove" role="alert">
                    <button aria-label="Close" class="close" data-bs-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Berhasil menyelesaikan pinjaman
                </div>
                <div class="alert alert-danger mg-b-0 d-none" id="failedApprove" role="alert">
                    <button aria-label="Close" class="close" data-bs-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Gagal menyelesaikan pinjaman
                </div>
            </div>
            <div class="row m-2">
                <fieldset>
                    <legend>Filter</legend>
                </fieldset>
                <form class="form-horizontal" action="{{ url('exportPeminjaman') }}" method="POST"
                    enctype="multipart/form-data" data-parsley-validate="">
                    @csrf
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Supplier</label>
                                <select id="supplier" name="supplier" class="form-control form-control-sm"
                                    placeholder="supplier">
                                    <option value="">Pilih Supplier</option>
                                    @foreach ($dataSupplier as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Tanggal Peminjaman</label>
                                <input type="text" id="start" name="start" placeholder="Tanggal Awal"
                                    onfocus="(this.type='date')" onblur="(this.type='text')"
                                    class="form-control form-control-sm " placeholder="Start">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="" style="color: white !important;">Selesai</label>
                                <input type="text" id="end" name="end" placeholder="Tanggal Akhir"
                                    onfocus="(this.type='date')" onblur="(this.type='text')"
                                    class="form-control form-control-sm" placeholder="End">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-sm btn-success " style="margin-top: 30px !important;" id="filter-button"
                                type="button"><i class="mdi mdi-filter"></i> Filter</button>
                            <button class="btn btn-sm btn-primary " style="margin-top: 30px !important;"
                                type="submit"><i class="mdi mdi-file-export"></i> Export</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">No</th>
                                <th class="border-bottom-0">Belandang</th>
                                <th class="border-bottom-0">Jumlah</th>
                                <th class="border-bottom-0 text-center">Total Angsuran</th>
                                <th class="border-bottom-0 text-center">Tanggal Peminjaman</th>
                                <th class="border-bottom-0 text-center">Status</th>
                                <th class="border-bottom-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                @php
                                    $totalAngsuran = count($item->angsuran);
                                    $totalBayar = 0;
                                    foreach ($item->angsuran as $itm) {
                                        $totalBayar += $itm->total_payment;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->supplier->name }}</td>
                                    <td class="text-center">{{ Helper::price($item->quantity, 'Rp. ') }}</td>
                                    <td class="text-center">{{ Helper::price($totalBayar, 'Rp. ') }}</td>
                                    <td class="text-center">{{ Helper::tanggal($item->loaning_date) }}</td>
                                    <td class="text-center">{{ ucfirst($item->status) }}</td>
                                    <td class="d-flex">

                                        @if ($totalAngsuran == 0)
                                            <a href="{{ route('peminjaman.edit', $item->id) }}"
                                                class="btn btn-sm btn-info me-2"> <i class="mdi mdi-pencil"></i>
                                                Ubah</a>

                                            <form action="{{ route('peminjaman.destroy', $item->id) }}" method="POST"
                                                onclick="return confirm('apakah anda yakin ingin menghapus data ini??')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger me-2"> <i
                                                        class="mdi mdi-delete"></i>
                                                    Hapus</button>
                                            </form>
                                        @endif
                                        @if ($totalBayar < $item->quantity)
                                            <button type="button" {{-- onclick="approve({{ $item->id }});" --}}
                                                data-bs-target="#paymentModal{{ $item->id }}" data-bs-toggle="modal"
                                                class="btn btn-sm btn-success me-2"> <i class="mdi mdi-check"></i>
                                                Bayar</button>
                                            <!-- Basic modal -->
                                            <div class="modal" id="paymentModal{{ $item->id }}">
                                                <div class="modal-dialog" role="document">
                                                    <form action="{{ url('/payment/' . $item->id) }}" method="post"
                                                        class="">
                                                        @csrf
                                                        <div class="modal-content modal-content-demo">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title">Pembayaran Pinjaman</h6><button
                                                                    aria-label="Close" class="close"
                                                                    data-bs-dismiss="modal" type="button"><span
                                                                        aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="">Tipe Pembayaran <span
                                                                                    class="tx-danger">*</span></label>
                                                                            <select id="type_payment" name="type_payment"
                                                                                class="form-control " required
                                                                                placeholder="type_payment">
                                                                                <option value="">Pilih Pembayaran
                                                                                </option>
                                                                                <option value="Cash">Cash</option>
                                                                                <option value="Transfer">Transfer</option>

                                                                            </select>


                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="">Jumlah Bayar <span
                                                                                    class="tx-danger">*</span></label>
                                                                            <input type="number" id="total_payment"
                                                                                name="total_payment" class="form-control"
                                                                                placeholder="Jumlah Pinjaman" required
                                                                                value="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn ripple btn-secondary"
                                                                    data-bs-dismiss="modal" type="button">Batal</button>
                                                                <button class="btn ripple btn-primary"
                                                                    type="submit">Simpan</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                        <button type="button" {{-- onclick="approve({{ $item->id }});" --}}
                                            data-bs-target="#paymentDetail{{ $item->id }}" data-bs-toggle="modal"
                                            class="btn btn-sm btn-success me-2"> <i class="mdi mdi-eye"></i>
                                            Detail</button>
                                        <!-- Basic modal -->
                                        <!-- Scroll with content modal -->
                                        <div class="modal" id="paymentDetail{{ $item->id }}">
                                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                <div class="modal-content modal-content-demo">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">Detail Angsuran</h6><button
                                                            aria-label="Close" class="close" data-bs-dismiss="modal"
                                                            type="button"><span
                                                                aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                                                                <thead>
                                                                    <th>Tanggal Pembayaran</th>
                                                                    <th>Jumlah Bayar</th>
                                                                    <th>Type Pembayaran</th>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($item->angsuran as $angs)
                                                                        <tr>
                                                                            <td>{{Helper::tanggalWaktu($angs->created_at)}}</td>
                                                                            <td>{{Helper::price($angs->total_payment)}}</td>
                                                                            <td>{{$angs->type_payment}}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        
                                                        <button class="btn ripple btn-secondary" data-bs-dismiss="modal"
                                                            type="button">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End Scroll with content modal -->
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
