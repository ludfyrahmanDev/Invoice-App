<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\BackOffice\Services\SummaryService;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Sale;
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
        $summary = (object)[
            'purchase' => 'Rp. 0',
            'purchase_not_paid' => 'Rp. 0',
            'purchase_weight' => 'Rp. 0',
            'week' => 'Rp. 0',
            'month' => 'Rp. 0',
            'year' => 'Rp. 0',
            'chart' => []
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
