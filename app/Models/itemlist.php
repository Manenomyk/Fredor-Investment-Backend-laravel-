<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itemlist extends Model
{
    use HasFactory;
    protected $table = 'itemlist';
    protected $fillable = [
        'description',
        'b_price',
        's_price',
    ];
}
