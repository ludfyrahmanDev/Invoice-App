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

    public function __construct($belandang, $start, $end)
    {
        $this->belandang = $belandang;
        $this->start = $start;
        $this->end = $end;
    }
    public function view(): View
    {
        try {
            $title = 'Laporan Keseluruhan';
            $type = 'all';
            $belandang = '';
            $list = Peminjaman::with('supplier');


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

            $data = (object) [
                'title' => $title,
                'type' => $type,
                'belandang' => $belandang,
                'data' => $list
            ];
            return view('layouts.export.excelTemplate', compact('data'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
