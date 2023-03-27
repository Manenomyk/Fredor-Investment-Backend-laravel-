<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customerlist extends Model
{
    use HasFactory;
    protected $table = 'customerlist';
    protected $fillable =[
        'plate_name',
        'plate_code',
        'driver',
        'id_no',
        'phone',
        'company',
    ];
}
