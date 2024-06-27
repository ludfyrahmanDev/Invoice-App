<?php

namespace App\Http\Controllers\BackOffice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
// suppliers
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

// import purchase
use App\Models\Purchase;
// import purchase detail
use App\Models\PurchaseDetail;

/**
 * model block
 */
class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Purchase::with('supplier')->get();
        $title = 'List Data Pembelian';
        return view('pages.backoffice.purchase.index', compact('data', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = 'Tambah Data Pembelian';
        $invoice_number = date('Ymd');
        $data = (object)[
            'name'              => '',
            'supplier_id'       => '',
            'invoice_number'    => $invoice_number,
            'invoice_code'      => '',
            'invoice_date'      => '',
            'initial_weight'    => '',
            'final_weight'      => '',
            'reject_weight'     => '',
            'subtotal'         => '',
            'tax'              => '',
            'total'            => '',
            'description'       => '',
            'status'            => '',
            'category_id'       => '',
            'purchase_price'    => '',
            'qty'               => '1',
            'selling_price'     => '',
            'type'              => 'create',
        ];
        $suppliers = Supplier::all();
        $categories = SubCategory::with('category')->get();
        return view('pages.backoffice.purchase.form', compact('categories','title', 'data','suppliers'));
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
        // dd($request->toArray());
        $request->validate([
            'supplier_id' => 'required',
            'invoice_number' => 'required',
            'invoice_code' => 'required',
            'invoice_date' => 'required|date',
            'initial_weight' => 'required',
            'final_weight' => 'required',
            'reject_weight' => 'required',
            'subtotal' => 'required',
            'description' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $total = array_sum($request->subtotal);
            $invoice_number = $request->invoice_number.'-'.$request->invoice_code;
            $data = ([
                'supplier_id' => $request->supplier_id,
                'invoice_number' => $invoice_number,
                // invoice date set date format
                'invoice_date' => date('Y-m-d', strtotime($request->invoice_date)),
                'initial_weight' => $request->initial_weight,
                'reject_weight' => $request->reject_weight,
                'final_weight' => $request->final_weight,
                'subtotal' => array_sum($request->subtotal),
                'tax' => $request->tax ?? 0,
                'total' => $total,
                'description' => $request->description,
                'status' => 'paid',
                'user_id' => auth()->user()->id,
            ]);
            $purchase = Purchase::create($data);
            $purchase_id = $purchase->id;
            foreach ($request->subcategory_id as $key => $value) {
                $data_detail = ([
                    'purchase_id' => $purchase_id,
                    'subcategory_id' => $value,
                    'qty' => $request->qty[$key],
                    'price' => $request->price[$key],
                    'subtotal' => $request->subtotal[$key],
                ]);
                PurchaseDetail::create($data_detail);
            }
            DB::commit();
            return redirect('purchase')->with('success', 'Berhasil menambah data!');
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
        $data = SubCategory::where('id', $id)->first();
        $title = 'Edit Data Pembelian';
        $categories = Category::all();
        return view('pages.backoffice.purchase.form', compact('data', 'title', 'categories'));
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
            'description' => 'required',
            'category_id' => 'required',
        ]);
        try {
            $data = ([
                'name' => $request->name,
                'description' => $request->description,
                'category_id' => $request->category_id,
            ]);

            SubCategory::where('id', $id)->update($data);
            return redirect('sub_category')->with('success', 'Berhasil mengubah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!');
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
        SubCategory::find($id)->delete();
        return redirect('sub_category')->with('success', 'Berhasil mengubah data!');
    }
}
