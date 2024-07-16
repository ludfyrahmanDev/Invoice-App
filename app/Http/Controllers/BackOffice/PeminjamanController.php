<?php

namespace App\Http\Controllers\BackOffice;

use App\Models\Peminjaman;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Peminjaman::all();
        $summary = ['paid' =>Peminjaman::where('status', 'paid')->count(),
                    'unpaid' =>Peminjaman::where('status', 'unpaid')->count()];
        $title = 'List Data Peminjaman';
        return view('pages.backoffice.loaning.index', compact('data', 'title', 'summary'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Tambah Data Peminjaman';
        $data = (object)[
            'id'           => '',
            'supplier'     => '',
            'quantity'     => '',
            'date'         => '',
            'type'         => 'create',
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
                'supplier_id'=>$request->supplier,
                'loaning_date'=>$request->date,
                'quantity'=>$request->quantity,
                'status'=>'unpaid',
                'created_by'=>Auth::user()->id,
                'updated_by'=>Auth::user()->id,
            ]);
            return redirect('peminjaman')->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data!'.$th->getMessage());
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
        $data = (object)[
            'id'              => $peminjaman->id,
            'supplier'        => $peminjaman->supplier_id,
            'quantity'        => $peminjaman->quantity,
            'date'            => $peminjaman->loaning_date,
            'type'            => 'edit',
            'dataSupplier'    => Supplier::all(),
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
            Peminjaman::where('id',$peminjaman->id)->update([
                'supplier_id'=>$request->supplier,
                'loaning_date'=>$request->date,
                'quantity'=>$request->quantity,
                'updated_by'=>Auth::user()->id,
            ]);
            return redirect('peminjaman')->with('success', 'Berhasil mengubah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!'.$th->getMessage());
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
            return redirect('peminjaman')->with('failed', 'Gagal menghapus data!'.$th->getMessage());
        }
    }

    public function approveTransaction($id){
        try {
            Peminjaman::where('id', $id)->update(['status' => 'paid', 'updated_by' => Auth::user()->id]);
            return true;
        } catch (\Throwable $th) {
            throw new Exception($th, 1);
            return false;
        }
    }
}
