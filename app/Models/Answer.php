<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $table = 'answer';
    protected $fillable = [
        'form_id',
        'answer',
        'key'
    ];

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }
}
