<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedeemMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'D_RedeemCusName',
        'D_RedeemCusMessage',
        'D_RedeemQty',
        'D_RedeemStatus'
    ];
}
