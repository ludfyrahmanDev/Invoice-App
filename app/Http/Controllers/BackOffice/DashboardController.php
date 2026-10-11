<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\BackOffice\Services\SummaryService;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Peminjaman;
use App\Models\Purchase;
use App\Models\PeminjamanDetail;
use Illuminate\Http\Request;

use Auth;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public SummaryService $service;

    public function __construct(SummaryService $service)
    {
        $this->service = $service;
    }
    public function index(Request $request)
    {
        //
        // $start_date = $request->start_date ?? date('Y');
        $start_Date =  $request->start_date ?? date('Y-m-d', strtotime('first day of january this year'));
        // get end date last date and month of this year
        $end_Date =  $request->end_date ?? date('Y-m-d', strtotime('last day of December this year'));
        $year = date('Y', strtotime($start_Date));
        $summary = [
            'paid' => [
                // make total key and value from total payment in relation angsuran in peminjaman
                'total' => PeminjamanDetail::whereHas('peminjaman', function($query) use($start_Date, $end_Date){
                    return $query->whereDate('created_at', '>=', $start_Date)
                        ->whereDate('created_at', '<=', $end_Date);
                })->sum('total_payment'),
                'count' => Peminjaman::whereDate('created_at', '>=', $start_Date)
                        ->whereDate('created_at', '<=', $end_Date)->where('status', 'paid')->count()
            ],
            'unpaid' => [
                'total' => Peminjaman::with('angsuran')->whereDate('created_at', '>=', $start_Date)
                        ->whereDate('created_at', '<=', $end_Date)->where('status', 'unpaid')->get()->sum(function ($item) {
                    $total = $item->quantity - $item->angsuran->sum('total_payment');
                    return $total;
                }),
                'count' => Peminjaman::whereDate('created_at', '>=', $start_Date)
                        ->whereDate('created_at', '<=', $end_Date)->where('status', 'unpaid')->count()
            ],
            'purchase' => [
                'today' => [
                    'value' => Purchase::whereDate('created_at', date('Y-m-d'))->sum('subtotal'),
                    'initial' => Purchase::whereDate('created_at', date('Y-m-d'))->sum('initial_weight'),
                    'final' => Purchase::whereDate('created_at', date('Y-m-d'))->with('purchase_detail')->get()->sum(function ($item) {
                        return $item->purchase_detail->sum('qty');
                    }),
                    'decrease' => Purchase::whereDate('created_at', date('Y-m-d'))->sum('final_weight') - Purchase::whereDate('created_at', date('Y-m-d'))->with('purchase_detail')->get()->sum(function ($item) {
                        return $item->purchase_detail->sum('qty');
                    }),
                    'reject' => Purchase::whereDate('created_at', date('Y-m-d'))->sum('reject_weight')
                ],
                'month' => [
                    'value' => Purchase::whereMonth('created_at', date('m'))->whereYear('created_at', $year)->sum('subtotal'),
                    'initial' => Purchase::whereMonth('created_at', date('m'))->whereYear('created_at', $year)->sum('initial_weight'),
                    'final' => Purchase::whereMonth('created_at', date('m'))->whereYear('created_at', $year)->with('purchase_detail')->get()->sum(function ($item) {
                        return $item->purchase_detail->sum('qty');
                    }),
                    'decrease' => Purchase::whereMonth('created_at', date('m'))->whereYear('created_at', $year)->sum('final_weight') - Purchase::whereMonth('created_at', date('m'))->whereYear('created_at', $year)->with('purchase_detail')->get()->sum(function ($item) {
                        return $item->purchase_detail->sum('qty');
                    }),
                    'reject' => Purchase::whereMonth('created_at', date('m'))->whereYear('created_at', $year)->sum('reject_weight')
                ],
                'year' => [
                    'value' => Purchase::whereYear('created_at', $year)->sum('subtotal'),
                    'initial' => Purchase::whereYear('created_at', $year)->sum('initial_weight'),
                    'final' => Purchase::whereYear('created_at', $year)->with('purchase_detail')->get()->sum(function ($item) {
                        return $item->purchase_detail->sum('qty');
                    }),
                    'decrease' => Purchase::whereYear('created_at', $year)->sum('final_weight') - Purchase::whereYear('created_at', $year)->with('purchase_detail')->get()->sum(function ($item) {
                        return $item->purchase_detail->sum('qty');
                    }),
                    'reject' => Purchase::whereYear('created_at', $year)->sum('reject_weight')
                ]
            ]
            // sum purchase by today

        ];
        $customers = [];
        return view('pages.backoffice.dashboard.index', compact('summary','request', 'customers', 'start_Date', 'end_Date'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }
}
