<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // return new Product([
        //     //
        // ]);

        // Logic to transform and save each row as a Transaction model
        $values = array_values($row);

        // Logic to transform and save each row as a Transaction model
        return new Product([
            'D_ProductID' => $values[0] ?? null,
            'D_ProductName' => $values[1] ?? null,
            'D_ProductQty' => $values[2] ?? null,
            'D_ProductPrice' => $values[3] ?? null,
            'D_ProductBrand' => $values[4] ?? null,
            'D_ProductImage' => $values[6] ?? null,
            'D_MinProductQty' => $values[7] ?? null,
            'D_ProductStatus' => $values[8] ?? null,
        ]);
    }
}
