<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded=[];
    protected $fillable = [
        'user_id','order_id', 'amount', 'type'
    ];
}
