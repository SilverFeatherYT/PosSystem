<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'D_RecID',
        'D_RecTotal',
        'D_RecCash',
        'D_RecChange',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'D_TranID');
    }
}
