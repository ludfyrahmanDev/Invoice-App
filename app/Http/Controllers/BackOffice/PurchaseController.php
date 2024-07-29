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
        $invoice_number = date('Ymd').rand(1,10);
        // add rand number to invoice number

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
        $parent = Category::with('subcategory')->get();
        // dd($parent->toArray());
        return view('pages.backoffice.purchase.form', compact('categories','title', 'data','suppliers', 'parent'));
    }


    public function print($id)
    {
        $data = Purchase::with('supplier', 'purchase_detail','purchase_detail.subcategory','purchase_detail.subcategory.category')->find($id);
        // group purchase detail with category
        $detail = [];
        foreach ($data->purchase_detail as $key => $purchase) {
            $detail[$purchase->subcategory->category->name][] = $purchase;
        }
        $data->detail = $detail;
        $title = 'Detail Data Pembelian';
        $pdf = \PDF::loadView('pages.backoffice.purchase.pdf', compact('data', 'title'));
        return $pdf->stream('invoice-'.$data->invoice_number.'.pdf');
    }

    public function report(Request $request){
        $suppliers = Supplier::all();
        $data = (object)[];
        $start_date = '';
        $reject_weight_presentase = '';
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        if($request->supplier_id){
            $date = date('Ymd', strtotime($request->date));
            $list = Purchase::with('supplier', 'purchase_detail','purchase_detail.subcategory','purchase_detail.subcategory.category')
            ->where('supplier_id', $request->supplier_id)
            ->where('invoice_number', 'like','%'.$date.'%')->get();
            $data = [];
            foreach ($list as $key => $item) {

                $detail = [];
                foreach ($item->purchase_detail as $key => $purchase) {
                    $detail[$purchase->subcategory->category->name][] = $purchase;
                }
                $item->detail = $detail;
                $data[] = $item;
            }
            $reject_weight_presentase = number_format(($list->sum('reject_weight') / ($list->sum('final_weight') == 0 ? 1 : $list->sum('final_weight')) * 100), 2);
        }

        $category = Category::all();

        $supplier_id = $request->supplier_id;

        $title = 'Laporan Data Pembelian';
        return view('pages.backoffice.purchase.report', compact('data', 'title', 'suppliers','reject_weight_presentase', 'supplier_id', 'request', 'category'));
    }


    public function allPrint(Request $request){
        $suppliers = Supplier::all();
        $data = (object)[];
        $date = '';
        $reject_weight_presentase = '';
        $filter_date = $request->date;

        if($request->supplier_id){
            $date = date('Ymd', strtotime($request->date));
            $list = Purchase::with('supplier', 'purchase_detail','purchase_detail.subcategory','purchase_detail.subcategory.category')->where('supplier_id', $request->supplier_id)->where('invoice_number', 'like','%'.$date.'%')->get();
            $data = [];
            foreach ($list as $key => $item) {

                $detail = [];
                foreach ($item->purchase_detail as $key => $purchase) {
                    $detail[$purchase->subcategory->category->name][] = $purchase;
                }
                $item->detail = $detail;
                $data[] = $item;
            }

            $reject_weight_presentase = number_format(($list->sum('reject_weight') / ($list->sum('final_weight') == 0 ? 1 : $list->sum('final_weight')) * 100), 2);
        }

        $supplier_id = $request->supplier_id;
        $supplier = Supplier::find($supplier_id);
        $title = 'Laporan Pembelian';
        $pdf = \PDF::loadView('pages.backoffice.purchase.allpdf', compact('data', 'title', 'suppliers','date','reject_weight_presentase', 'supplier_id', 'date','filter_date','supplier'));
        return $pdf->stream('invoice-'.$date.'.pdf');
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
            'description' => 'nullable',
        ]);

        try {
            DB::beginTransaction();
            $total = array_sum($request->subtotal);
            $invoice_number = $request->invoice_number.'-'.$request->invoice_code;
            // validate invoice number
            $check = Purchase::where('invoice_number', $invoice_number)->first();
            if ($check) {
                return back()->with('failed', 'Nomor invoice sudah ada!');
            }
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
                'description' => $request->description ?? '-',
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
            // redirect to detail
            return redirect('purchase/'.$purchase_id)->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data!'.$th->getMessage());
        }
    }


    public function checkInvoice($invoice)
    {
        $data = Purchase::where('invoice_number', $invoice)->first();
        if ($data) {
            return response()->json(['status' => 'success', 'data' => $data]);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Data tidak ditemukan!']);
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
        $data = Purchase::with('supplier', 'purchase_detail','purchase_detail.subcategory','purchase_detail.subcategory.category')->find($id);
        // group purchase detail with category
        $detail = [];
        foreach ($data->purchase_detail as $key => $purchase) {
            $detail[$purchase->subcategory?->category?->name][] = $purchase;
        }
        $data->detail = $detail;
        $title = 'Detail Data Pembelian';
        return view('pages.backoffice.purchase.show', compact('data', 'title'));
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
        $data = Purchase::with('purchase_detail','purchase_detail.subcategory')->where('id', $id)->first();
        $invoice = explode('-', $data->invoice_number);
        $data->invoice_number = $invoice[0];
        $data->invoice_code = $invoice[1];
        $suppliers = Supplier::all();
        $categories = SubCategory::with('category')->get();
        $title = 'Edit Data Pembelian';
        $data->type = 'edit';
        $parent = Category::with('subcategory')->get();
        return view('pages.backoffice.purchase.form', compact('data', 'title','suppliers', 'categories','parent'));
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
            // validate invoice number
            $check = Purchase::where('invoice_number', $invoice_number)->count();
            if ($check > 1) {
                return back()->with('failed', 'Nomor invoice sudah ada!');
            }
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
                'description' => $request->description ?? '-',
                'status' => 'paid',
                'user_id' => auth()->user()->id,
            ]);
            $purchase = Purchase::find($id)->update($data);
            $purchase_id = $id;
            Purchase::find($id)->purchase_detail()->delete();
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
            return redirect('purchase')->with('success', 'Berhasil mengubah data!');
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
        SubCategory::find($id)->delete();
        return redirect('sub_category')->with('success', 'Berhasil mengubah data!');
    }
}
