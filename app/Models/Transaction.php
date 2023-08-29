<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'D_TranID',
        'D_TranCusName',
        'D_TranProductName',
        'D_TranProductQty',
        'D_TranProductPrice',
        'D_TranPaymentType',
    ];

    public function receipt()
    {
        return $this->hasOne(Receipt::class, 'D_RecID', 'D_TranID');
    }
}
