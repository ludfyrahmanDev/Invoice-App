<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// import soft delete
use Illuminate\Database\Eloquent\SoftDeletes;
class Purchase extends Model
{
    use HasFactory, SoftDeletes;
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
        'user_id',
        'created_at',
    ];

    protected $appends = ['reject_weight_presentase'];

    // relation to supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function getInitialWeightAttribute($value)
    {
        // remove decimal behind comma
        $value = str_replace(',', '', number_format($value, 0));
        return $value;
    }


    public function getFinalWeightAttribute($value)
    {
        // remove decimal
        $value = str_replace(',', '', number_format($value, 0));
        return $value;
    }

    public function getRejectWeightAttribute($value)
    {
        // remove decimal
        $value = str_replace(',', '', number_format($value, 0));
        return $value;
    }

    public function getRejectWeightPresentaseAttribute()
    {
        $result =($this->reject_weight?? 0)/ ($this->initial_weight ?? 0) * 100;
        // get 2 decimal
        return number_format($result, 0);
    }

    public function purchase_detail()
    {
        return $this->hasMany(PurchaseDetail::class, 'purchase_id', 'id');
    }

}
