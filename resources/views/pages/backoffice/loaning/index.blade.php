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
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">No</th>
                                <th class="wd-25p border-bottom-0">Belandang</th>
                                <th class="wd-10p border-bottom-0">Jumlah</th>
                                <th class="wd-15p border-bottom-0">Tanggal Peminjaman</th>
                                <th class="wd-10p border-bottom-0">Status</th>
                                <th class="wd-30p border-bottom-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->supplier->name }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-center">{{ $item->loaning_date }}</td>
                                    <td class="text-center">{{ $item->status }}</td>
                                    <td class="d-flex">

                                        @if ($item->status == 'unpaid')
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
                                            <button type="button" onclick="approve({{ $item->id }});"
                                                id="approveButton" class="btn btn-sm btn-success me-2"> <i
                                                    class="mdi mdi-check"></i>
                                                Selesaikan</button>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        function approve(id) {
            $.ajax({
                url: '/approveTransaction/' + id,
                type: 'GET',
                success: function(response) {
                    $('#successApprove').removeClass('d-none');
                    setTimeout(function() {
                        location.reload();
                    }, 2000); // 2000 mil
                },
                error: function(xhr, status, error) {
                    $('#failedApprove').removeClass('d-none');
                }
            });
        }
    </script>
@endsection
