<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $table = 'purchases';
    protected $fillable = [
        'supplier_id',
        'invoice_number',
        'invoice_code',
        'invoice_date',
        'initial_weight',
        'final_weight',
        'reject_weight',
        'subtotal',
        'tax',
        'total',
        'description',
        'status',
        'user_id'
    ];


    // relation to supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
    
}
