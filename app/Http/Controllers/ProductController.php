<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;

use App\Models\Product;

class ProductController extends Controller
{

    public function viewProduct()
    {
        Config::set('app.name', 'Product');

        $products = Product::paginate(10);
        return view('admin.Product')->with('products', $products);
    }

    public function addProduct(Request $r)
    {
        $validated = Validator::make(
            $r->all(),
            [
                'productName' => 'required',
                'productQty' => 'required|numeric|min:1|max:999',
                'productPrice' => 'required',
                'productImage' => 'image|mimes:jpeg,png,gif,svg|max:2048',
            ]

        );

        if (!$validated->passes()) {
            return response()->json(['status' => 0, 'error' => $validated->errors()->toArray()]);
            // return redirect()->back()->withErrors($validated)->withInput();
        } else {

            if ($r->file('productImage') != '') { //if user upload something
                $image = $r->file('productImage');
                $image->move('images', $image->getClientOriginalName()); //images is the location
                $imageName = $image->getClientOriginalName();
            } else {
                $imageName = null;
            }

            $addProduct = Product::create([
                'D_ProductID' => $r->productID,
                'D_ProductName' => $r->productName,
                'D_ProductQty' => $r->productQty,
                'D_ProductPrice' => $r->productPrice,
                'D_ProductBrand' => $r->productBrand, 'D_ProductImage' => $imageName,
                'D_MinProductQty' => $r->minProductQty,
                'D_Barcode' => $r->barcode,

            ]);

            if ($addProduct) {
                return response()->json(['status' => 1, 'msg' => 'Product Add Success']);
                // return redirect()->back()->with('status', 'Product Add Success');
                // return back()->with('message','Product Add Success');
            }
        }

        return redirect()->back();
    }

    public function updateProduct(Request $r)
    {
        $validated = Validator::make(
            $r->all(),
            [
                'productName' => 'required',
                'productQty' => 'required|numeric|min:1|max:999',
                'productPrice' => 'required',
                'productImage' => 'image|mimes:jpeg,png,gif,svg|max:2048',
            ]

        );

        if (!$validated->passes()) {
            return response()->json(['status' => 0, 'error' => $validated->errors()->toArray()]);
            // return redirect()->back()->withErrors($validated)->withInput();

        } else {
            if ($r->file('productImage') != '') { //if user upload something
                $image = $r->file('productImage');
                $image->move('images', $image->getClientOriginalName()); //images is the location
                $imageName = $image->getClientOriginalName();
            } else {
                $imageName = null;
            }

            $product = Product::find($r->id); //retrive data from product table
            $product->D_ProductID = $r->productID; //binding data with html input
            $product->D_ProductName = $r->productName;
            $product->D_ProductQty = $r->productQty;
            $product->D_ProductPrice = $r->productPrice;
            $product->D_ProductBrand = $r->productBrand;
            $product->D_ProductImage = $imageName;
            $product->D_MinProductQty = $r->minProductQty;
            $product->D_Barcode = $r->barcode;

            $product->save(); //save the data to MySQL

            if ($product->save()) {
                return response()->json(['status' => 1, 'msg' => 'Product Update Success']);
                // return redirect()->back()->with('status', 'Product Update Success');
            }
        }

        return redirect()->back();
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if ($product->delete()) {
            return redirect()->back()->with('status', 'Product Delete Success');
        } else {
            return redirect()->back()->with('status', 'Product Delete Failed');
        }
    }

    public function deleteAllProduct(Request $r)
    {
        // return $r->all();
        // Get the selected product IDs from the request
        $selectedProducts = json_decode($r->input('selectedProducts'));

        // Perform the deletion of selected products
        // You can use the Product model and the delete method to delete multiple products at once
        Product::whereIn('id', $selectedProducts)->delete();

        return redirect()->back()->with('status', 'Selected products have been deleted.');
    }

    public function getProductByBarcode($barcode)
    {
        $product = Product::where('D_Barcode', $barcode)->first();

        if (!$product) {
            return response()->json([
                'error' => false,
                'message' => 'Product not found for the given barcode.',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product Add Success',
            'product' => $product,
        ]);
    }
}
