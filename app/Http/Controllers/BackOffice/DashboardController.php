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

        $summary = [
            'paid' => [
                // make total key and value from total payment in relation angsuran in peminjaman
                'total' => PeminjamanDetail::sum('total_payment'),
                'count' => Peminjaman::where('status', 'paid')->count()
            ],
            'unpaid' => [
                'total' => Peminjaman::with('angsuran')->where('status', 'unpaid')->get()->sum(function ($item) {
                    $total = $item->quantity - $item->angsuran->sum('total_payment');
                    return $total;
                }),
                'count' => Peminjaman::where('status', 'unpaid')->count()
            ],
            'purchase' => [
                'today' => Purchase::whereDate('created_at', date('Y-m-d'))->sum('subtotal'),
                'month' => Purchase::whereMonth('created_at', date('m'))->sum('subtotal'),
                'year' => Purchase::whereYear('created_at', date('Y'))->sum('subtotal')
            ]
            // sum purchase by today

        ];
        $customers = [];
        return view('pages.backoffice.dashboard.index', compact('summary', 'customers'));
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
