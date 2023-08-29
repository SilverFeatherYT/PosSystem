<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'D_ProductID',
        'D_ProductName',
        'D_ProductQty',
        'D_ProductPrice',
        'D_ProductBrand',
        'D_ProductImage',
        'D_MinProductQty',
        'D_Barcode'
    ];
}
