<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'alias',
        'parent_id',
        'address',
        'phone',
        'bank',
        'account_number',
        'pajak',
    ];

    protected $appends = ['name_alias'];

    // change name attribute to uppercase
    public function getNameAliasAttribute($value)
    {
        $alias = $this->alias;
        $result = $this->name;
        if ($alias != null && $alias != '') {
            $result = $result . ' (' . $alias . ')';
        }
        return $result;

    }
    // relation to purchase
    public function purchase()
    {
        return $this->hasMany(Purchase::class);
    }

    public function parent()
    {
        return $this->belongsTo(Supplier::class, "parent_id", "id");
    }

}
