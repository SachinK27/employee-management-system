<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    use HasFactory;
    public $fillable=
    [
        'task','assigned_by','assigned_to','assign_date','deadline','status','notes','priority'
    ];
}
