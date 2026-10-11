<?php

namespace App\Http\Controllers\BackOffice;

use App\Exports\PeminjamanExport;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Auth;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Peminjaman::query();
        $start_Date =  $request->start ?? date('Y-m-d', strtotime('first day of january this year'));
        // get end date last date and month of this year
        $end_Date =  $request->end ?? date('Y-m-d', strtotime('last day of December this year'));
        if ($request->supplier) {

            $query = $query->where("supplier_id", $request->supplier);
        }
        // if ($request->start && $request->end) {
            $query = $query->whereBetween('loaning_date', [$start_Date, $end_Date]);
        // }
        $month = date('m');
        $year = date('y');
        $data = $query->orderBy("id", "desc")->get();
        $summary = [
            'paid' => [
                // make total key and value from total payment in relation angsuran in peminjaman
                'total' => PeminjamanDetail::whereHas('peminjaman', function($query) use($start_Date, $end_Date){
                    return $query->whereBetween('created_at', [$start_Date, $end_Date]);
                })->sum('total_payment'),
                'count' => Peminjaman::where('status', 'paid')->whereBetween('created_at', [$start_Date, $end_Date])->count()
            ],
            'unpaid' => [
                'total' => Peminjaman::with('angsuran')->whereBetween('created_at', [$start_Date, $end_Date])->where('status', 'unpaid')->get()->sum(function ($item) {
                    $total = $item->quantity - $item->angsuran->sum('total_payment');
                    return $total;
                }),
                'count' => Peminjaman::where('status', 'unpaid')->whereBetween('created_at', [$start_Date, $end_Date])->count()
            ]
        ];
        $title = 'List Data Peminjaman';
        $dataSupplier = Supplier::all();
        return view('pages.backoffice.loaning.index', compact('data','start_Date', 'end_Date', 'title', 'summary', 'dataSupplier', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Tambah Data Peminjaman';
        $data = (object) [
            'id' => '',
            'supplier' => '',
            'quantity' => '',
            'date' => '',
            'type' => 'create',
            'dataSupplier' => Supplier::all(),
        ];
        return view('pages.backoffice.loaning.form', compact('title', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            Peminjaman::create([
                'supplier_id' => $request->supplier,
                'loaning_date' => $request->date,
                'quantity' => $request->quantity,
                'status' => 'unpaid',
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]);
            return redirect('peminjaman')->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data!' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Peminjaman  $loaning
     * @return \Illuminate\Http\Response
     */
    public function show(Peminjaman $loaning)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Peminjaman  $loaning
     * @return \Illuminate\Http\Response
     */
    public function edit(Peminjaman $peminjaman)
    {

        $title = 'Edit Data Peminjaman';
        $data = (object) [
            'id' => $peminjaman->id,
            'supplier' => $peminjaman->supplier_id,
            'quantity' => $peminjaman->quantity,
            'date' => $peminjaman->loaning_date,
            'type' => 'edit',
            'dataSupplier' => Supplier::all(),
        ];
        return view('pages.backoffice.loaning.form', compact('data', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Peminjaman  $loaning
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        try {
            Peminjaman::where('id', $peminjaman->id)->update([
                'supplier_id' => $request->supplier,
                'loaning_date' => $request->date,
                'quantity' => $request->quantity,
                'updated_by' => Auth::user()->id,
            ]);
            return redirect('peminjaman')->with('success', 'Berhasil mengubah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Peminjaman  $loaning
     * @return \Illuminate\Http\Response
     */
    public function destroy(Peminjaman $peminjaman)
    {
        try {

            $peminjaman->delete();
            return redirect('peminjaman')->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            return redirect('peminjaman')->with('failed', 'Gagal menghapus data!' . $th->getMessage());
        }
    }


    public function approveTransaction(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            $cek = PeminjamanDetail::where('peminjaman_id', $id)->sum('total_payment');
            $data = Peminjaman::where('id', $id)->first();
            $tmpTotal = intval($request->total_payment) + $cek;
            if ($tmpTotal > $data->quantity) {
                $sisa = $request->total_payment - $data->quantity;
                $supplier_id = $data->supplier_id;
                $peminjaman = Peminjaman::where('supplier_id', $supplier_id)->where('status', 'unpaid')->get();
                if($sisa > 0){
                    PeminjamanDetail::create([
                        'peminjaman_id' => $id,
                        'type_payment' => $request->type_payment,
                        'total_payment' => $data->quantity,
                        'description' => $request->description,
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                    ]);
                    if (($cek + $data->quantity) == $data->quantity) {
                        Peminjaman::where('id', $id)->update(['status' => 'paid', 'updated_by' => Auth::user()->id]);
                    }
                    foreach ($peminjaman as $key => $value) {
                        $sisaPinjaman = $value->quantity - PeminjamanDetail::where('peminjaman_id', $value->id)->sum('total_payment');
                        $sisaBayar = $sisaPinjaman - $sisa;
                        if($sisaBayar >= 0){
                            $sisaLoan = $sisa - $sisaPinjaman;
                            PeminjamanDetail::create([
                                'peminjaman_id' => $value->id,
                                'type_payment' => $request->type_payment,
                                'total_payment' =>$sisaLoan < 0 ? $sisa : $sisaPinjaman,
                                'description' => $request->description,
                                'created_by' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                            $sisa = 0;
                        }else{
                            $sisa = $sisa - $sisaPinjaman;
                            PeminjamanDetail::create([
                                'peminjaman_id' => $value->id,
                                'type_payment' => $request->type_payment,
                                'total_payment' => abs($sisaBayar),
                                'description' => $request->description,
                                'created_by' => Auth::user()->id,
                                'updated_by' => Auth::user()->id,
                            ]);
                        }
                        $total = $value->quantity;
                        $totalPembayaran = PeminjamanDetail::where('peminjaman_id', $value->id)->sum('total_payment');
                        if($total == $totalPembayaran){
                            Peminjaman::where('id', $value->id)->update(['status' => 'paid', 'updated_by' => Auth::user()->id]);
                        }

                        
                        if($sisa <= 0){
                            break;
                        }
    
                    }
                }
                // return redirect('peminjaman')->with('failed', 'Jumlah pembayaran melebihi jumlah pinjaman!');
            }else{
                PeminjamanDetail::create([
                    'peminjaman_id' => $id,
                    'type_payment' => $request->type_payment,
                    'total_payment' => $request->total_payment,
                    'description' => $request->description,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);
            }
            
            if ($tmpTotal == $data->quantity) {
                Peminjaman::where('id', $id)->update(['status' => 'paid', 'updated_by' => Auth::user()->id]);
            }

            DB::commit();
            return redirect('peminjaman')->with('success', 'Berhasil melakukan pembayaran!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('failed', 'Gagal melakukan pembayaran!');
        }
    }

    public function updatePaymentDetail(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            $old = PeminjamanDetail::where('id', $id)->first();
            $cek = PeminjamanDetail::where('peminjaman_id', $old->peminjaman_id)->sum('total_payment');
            $tmpTotal =  ($cek - $old->total_payment) + $request->total_payment;
            $body = [
                'type_payment' => $request->type_payment,
                'total_payment' => $request->total_payment,
                'description' => $request->description,
                'updated_by' => Auth::user()->id,
            ];
            $data = Peminjaman::where('id', $old->peminjaman_id)->first();

            if ($tmpTotal > $data->quantity) {

                return redirect('peminjaman')->with('failed', 'Jumlah pembayaran melebihi jumlah pinjaman!');
            }
            // return $tmpTotal;
            PeminjamanDetail::where('id', $id)->update($body);
            if ($tmpTotal == $data->quantity) {

                Peminjaman::where('id', $old->peminjaman_id)->update(['status' => 'paid', 'updated_by' => Auth::user()->id]);
            }else{
                Peminjaman::where('id', $old->peminjaman_id)->update(['status' => 'unpaid', 'updated_by' => Auth::user()->id]);
            }

            DB::commit();
            return redirect('peminjaman')->with('success', 'Berhasil mengubah pembayaran!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
            return back()->with('failed', 'Gagal mengubah pembayaran!');
        }
    }

    public function exportTransaction(Request $request)
    {


        try {

            $belandang = $request->get('supplier');
            $start = $request->get('start');
            $end = $request->get('end');
            $title = 'Laporan Keseluruhan';
            if($request->type == 'recapt'){
                $title = 'Laporan Rekapitulasi';
            }
            return Excel::download(new PeminjamanExport($belandang, $start, $end, $request), $title.'.xlsx');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
