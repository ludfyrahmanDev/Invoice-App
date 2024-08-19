<?php
namespace App\Helper;

use App\Models\Apps;
use App\Models\Form;

use Carbon\Carbon;
use App\Models\ProfileCompany;
class Helper{

    public static function result_form($usability_id){
        $form = Form::with('subcategory', 'subcategory.category')->whereHas('subcategory.category', function($query) use ($usability_id){
            $query->where('id', $usability_id);
        });
        return $form;
    }
    public static function profile(){
        return Apps::first();
    }
    public static function tanggal($tgl)
    {
        $qq = '';
        // $dt = explode(" ", $tgl);
        $k = explode("-", $tgl);
        $bln = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
        $qq = $k[2] . ' ' . $bln[(int)$k[1]] . ' ' . $k[0];
        return $qq;
    }

    public static function tanggalWaktu($tgl)
    {
        $qq = '';
        $dt = explode(" ", $tgl);
        $k = explode("-", $dt[0]);
        $bln = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
        $qq = $k[2] . ' ' . $bln[(int)$k[1]] . ' ' . $k[0] . ' ' . $dt[1];
        return $qq;
    }

    public static function price($price,$prefix = 'Rp')
    {
        $result = $prefix.' '.(number_format($price, 0, ',', '.'));
        return $result;
    }
    public static function number($number)
    {
        $result = (number_format($number, 0, ',', '.'));
        return $result;
    }
}
