<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// import soft delete
use Illuminate\Database\Eloquent\SoftDeletes;
class Peminjaman extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'peminjaman';
    protected $fillable = [
        'supplier_id',
        'loaning_date',
        'quantity',
        'created_by',
        'updated_by',
    ];


    // relation to purchase
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, "supplier_id", "id");
    }

    public function angsuran()
    {
        return $this->hasMany(PeminjamanDetail::class, "peminjaman_id", "id");
    }


    public function creator()
    {
        return $this->belongsTo(User::class, "created_by", "id");
    }

    public function updator()
    {
        return $this->belongsTo(User::class, "updated_by", "id");
    }
}
