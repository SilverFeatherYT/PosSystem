<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedeemItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'D_RedeemItemID',
        'D_RedeemItemName',
        'D_RedeemItemQty',
        'D_RedeemItemPoint',
        'D_RedeemItemImage',
        'D_RedeemItemStatus',
    ];
}
