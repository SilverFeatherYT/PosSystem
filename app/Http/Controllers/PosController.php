<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Receipt;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\View;

class PosController extends Controller
{
    public function viewPos()
    {
        Config::set('app.name', 'POS SYSTEM');

        $product = Product::paginate(15);
        $trans = Transaction::max('D_TranID');

        $receipts = DB::table('receipts')
            ->leftjoin('transactions', 'transactions.D_TranID', '=', 'receipts.D_RecID')
            ->select('receipts.*', 'transactions.D_TranCusName as cusName', 'transactions.D_TranProductName as prodname', 'transactions.D_TranProductQty as prodqty', 'transactions.D_TranProductPrice as prodprice' ,'transactions.D_TranPaymentType as payment')
            ->where('transactions.D_TranID', $trans)
            ->get();

        $existingCustomerPhones = Customer::pluck('D_CusPhone')->toArray();

        return view('admin.Pos')->with('products', $product)->with('existingCustomerPhones', $existingCustomerPhones)->with('receipts', $receipts);
    }

    public function pospaginate(Request $r)
    {
        Config::set('app.name', 'POS SYSTEM');

        if ($r->ajax()) {
            $product = Product::paginate(15);
            $trans = Transaction::max('D_TranID');
            $receipts = DB::table('receipts')
                ->leftjoin('transactions', 'transactions.D_TranID', '=', 'receipts.D_RecID')
                ->select('receipts.*', 'transactions.D_TranProductName as prodname', 'transactions.D_TranProductQty as prodqty', 'transactions.D_TranProductPrice as prodprice')
                ->where('transactions.D_TranID', $trans)
                ->get();

            return view('Paginate.option')->with('products', $product)->with('receipts', $receipts)->render();
        }
    }

    public function addPos(Request $r)
    {
        $orderProducts = json_decode($r->input('order_products'), true);
        $paymentMethod = $r->input('payment_method');
        $customerphone = Customer::where('D_CusPhone', $r->input('cusPhone'))->first();
        $user = null;

        // Check if $customerphone is not null before accessing its properties
        if ($customerphone) {
            $user = User::where('user_id', $customerphone->D_CusID)->first();
        }

        if ($r->input('cusPhone') != '') { // Check if customer input has data
            if (!$customerphone) { // Create a new customer if it doesn't exist
                return redirect()->back()->with('error', 'Customer Not Found');
            } else {

                // Generate the unique D_TranID by counting existing transactions and adding 1
                $tranCount = Transaction::max('D_TranID');
                $tranID = $tranCount + 1;

                foreach ($orderProducts as $orderProduct) {
                    $selProductName = $orderProduct['product_name'];
                    $selProductQty = $orderProduct['product_qty'];
                    $selProductPrice = $orderProduct['product_price'];
                    $selTotalPrice = $r->input('showtotal');

                    $product = Product::where('D_ProductName', $selProductName)->first();

                    // Save the order product data to the database
                    $Transaction = Transaction::create([
                        'D_TranID' => $tranID,
                        'D_TranCusName' => $user ? $user->name : null,
                        'D_TranProductName' => $selProductName,
                        'D_TranProductQty' => $selProductQty,
                        'D_TranProductPrice' => $selProductPrice,
                        'D_TranPaymentType' => $paymentMethod,
                    ]);

                    if ($Transaction) {
                        $product->D_ProductQty -= $selProductQty;
                        $product->save();
                    }
                }

                $memberPoint = intval($selTotalPrice) / 10;
                $customerphone->D_CusMemberPoint += $memberPoint;
                $customerphone->save();

                $receipt = Receipt::create([
                    'D_RecID' => $tranID,
                    'D_RecTotal' => $selTotalPrice,
                    'D_RecCash' => $r->receiveCash,
                    'D_RecChange' => $r->Cashback,
                ]);
            }
        } else {
            // Generate the unique D_TranID by counting existing transactions and adding 1
            $tranCount = Transaction::max('D_TranID');
            $tranID = $tranCount + 1;

            foreach ($orderProducts as $orderProduct) {
                $selProductName = $orderProduct['product_name'];
                $selProductQty = $orderProduct['product_qty'];
                $selProductPrice = $orderProduct['product_price'];
                $selTotalPrice = $r->input('showtotal');

                $product = Product::where('D_ProductName', $selProductName)->first();

                // Save the order product data to the database
                $Transaction = Transaction::create([
                    'D_TranID' => $tranID,
                    'D_TranCusName' => $user ? $user->name : null,
                    'D_TranProductName' => $selProductName,
                    'D_TranProductQty' => $selProductQty,
                    'D_TranProductPrice' => $selProductPrice,
                    'D_TranPaymentType' => $paymentMethod,
                ]);

                if ($Transaction) {
                    $product->D_ProductQty -= $selProductQty;
                    $product->save();
                }
            }

            $memberPoint = intval($selTotalPrice) / 10;
            if ($customerphone) {
                $customerphone->D_CusMemberPoint += $memberPoint;
                $customerphone->save();
            }

            $receipt = Receipt::create([
                'D_RecID' => $tranID,
                'D_RecTotal' => $selTotalPrice,
                'D_RecCash' => $r->receiveCash,
                'D_RecChange' => $r->Cashback,
            ]);
        }
        return redirect()->back()->with('status', 'Order Add Success');
    }
}
