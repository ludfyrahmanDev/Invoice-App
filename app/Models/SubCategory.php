<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'sub_category';
    protected $fillable = [
        'name',
        'description',
        'purchase_price',
        'selling_price',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class, 'subcategory_id', 'id');
    }
}
