<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // return Product::all();

        $product = Product::select(
            "D_ProductID",
            "D_ProductName",
            "D_ProductQty",
            "D_ProductPrice",
            "D_ProductBrand",
            "D_ProductImage",
            "D_MinProductQty",
            "D_Barcode"
        )->get();

        return $product;
    }

    public function headings(): array
    {
        return ["ProductID", "ProductName", "ProductQty", "ProductPrice", "ProductBrand", "Image", "MinProductQty", "Barcode"];
    }
}
