<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;
    protected $table = 'purchase_detail';
    protected $fillable = [
        'purchase_id',
        'subcategory_id',
        'qty',
        'price',
        'subtotal',
    ];

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
    }
}
