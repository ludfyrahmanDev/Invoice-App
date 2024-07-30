<?php

namespace App\Exports;

use App\Models\Peminjaman;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PeminjamanExport implements ShouldAutoSize,FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $belandang;
    protected $start;
    protected $end;
    protected $request;

    public function __construct($belandang, $start, $end, $request)
    {
        $this->belandang = $belandang;
        $this->start = $start;
        $this->end = $end;
        $this->request = $request;
    }
    public function view(): View
    {
        try {
            $title = 'Laporan Keseluruhan';
            $type = 'all';
            $belandang = '';
            $list = Peminjaman::with('supplier', 'angsuran');

            if (!empty($this->belandang)) {
                $list = $list->where('supplier_id', $this->belandang);
                $title = 'Laporan Per Belandang';
                $type = 'belandang';
                $belandang = Supplier::where('id', $this->belandang)->first()->name;
            }

            if (!empty($this->start) && !empty($this->end)) {
                $list = $list->whereBetween('loaning_date', [$this->start, $this->end]);
            }



            $list = $list->get();

            $view = 'layouts.export.excelTemplate';
            if($this->request->type == 'recapt'){
                $title = 'Laporan Rekapitulasi';
                $view = 'layouts.export.loanRecapt';


                // group by supplier id and sum quantity and angsuran->total_payment
                $list = $list->groupBy('supplier_id')->map(function ($item) {
                    return (object)[
                        'supplier' => (object)[
                            'name_alias' => $item[0]->supplier->name_alias
                        ],
                        'quantity' => $item->sum('quantity'),
                        'total_payment' => $item->sum(function ($item) {
                            return $item->angsuran->sum('total_payment');
                        }),
                        // unpaid
                        'unpaid' => $item->sum(function ($item) {
                            return $item->quantity - $item->angsuran->sum('total_payment');
                        }),

                    ];
                });

            }
            $data = (object) [
                'title' => $title,
                'type' => $type,
                'belandang' => $belandang,
                'data' => $list
            ];

            return view($view, compact('data'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
