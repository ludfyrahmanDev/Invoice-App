<?php

namespace App\Http\Controllers\BackOffice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Supplier;

/**
 * model block
 */
class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Supplier::with('purchase')->get();
        $title = 'List Data Belandang';
        return view('pages.backoffice.supplier.index', compact('data', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = 'Tambah Data Belandang';
        $data = (object)[
            'name'              => '',
            'alias'             => '',
            'parent_id'         => '',
            'address'           => '',
            'phone'             => '',
            'bank'              => '',
            'account_number'    => '',
            'pajak'    => '',
            'type'              => 'create',
        ];
        $supplier = Supplier::where('parent_id', null)->get();
        return view('pages.backoffice.supplier.form', compact('title', 'data', 'supplier'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'bank' => 'nullable',
            'account_number' => 'nullable',
            // set required parent id if employee is not null
            'parent_id' => $request->has('employee') ? 'required' : 'nullable',
        ]);


        try {
            if(!$request->has('employee')){
                $request->parent_id = null;
            }
            Supplier::create([
                'name' => $request->name,
                'alias' => $request->alias ?? '',
                'address' => $request->address,
                'phone' => $request->phone,
                'parent_id' => $request->parent_id ?? null,
                'bank' => $request->bank ?? '',
                'pajak' => $request->pajak??0,
                'account_number' => $request->account_number ?? '',
            ]);
            return redirect('supplier')->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data!'.$th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = Category::where('id', $id)->first();
        $title = 'Detail Data Belandang';
        $data->type = 'detail';

        return view('pages.backoffice.supplier.form', compact('data', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = Supplier::find($id);
        $title = 'Edit Data Belandang';
        $data->type = 'edit';
        $supplier = Supplier::where('parent_id', null)->get();
        return view('pages.backoffice.supplier.form', compact('data', 'title', 'supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'bank' => 'nullable',
            'account_number' => 'nullable',
            'parent_id' => $request->has('employee') ? 'required' : 'nullable',
        ]);
        try {
            $check = Supplier::where('name', $request->name);

            $supplier = Supplier::find($id);
            $supplier->name = $request->name;
            $supplier->alias = $request->alias ?? '';
            $supplier->address = $request->address;
            $supplier->phone = $request->phone;
            $supplier->parent_id = $request->parent_id ?? null;
            $supplier->bank = $request->bank ?? '';
            $supplier->account_number = $request->account_number ?? '';
            $supplier->pajak = $request->pajak;
            $supplier->save();
            return redirect('supplier')->with('success', 'Berhasil mengubah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!'.$th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Supplier::find($id)->delete();
        return redirect('supplier')->with('success', 'Berhasil menghapus data!');
    }
}
