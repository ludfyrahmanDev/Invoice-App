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
}
