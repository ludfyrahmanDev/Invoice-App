<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apps extends Model
{
    use HasFactory;
    protected $table = 'apps';
    protected $fillable = ['name', 'logo', 'description'];
}
