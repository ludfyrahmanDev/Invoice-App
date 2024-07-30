<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanDetail extends Model
{
    use HasFactory;
    protected $table = "peminjaman_detail";
    protected $fillable = ['peminjaman_id', 'type_payment', 'total_payment', 'description', 'created_by', 'updated_by'];
    public function creator()
    {
        return $this->belongsTo(User::class, "created_by", "id");
    }

    public function updator()
    {
        return $this->belongsTo(User::class, "updated_by", "id");
    }
}
