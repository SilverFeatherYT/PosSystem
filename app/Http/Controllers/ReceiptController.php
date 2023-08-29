<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction;

class ReceiptController extends Controller
{
    public function viewReceipt(Request $r)
    {
        $receipts = DB::table('receipts')
            ->leftjoin('transactions', 'transactions.D_TranID', '=', 'receipts.D_RecID')
            ->select('receipts.*', 'transactions.D_TranCusName as cusName', 'transactions.D_TranProductName as prodname', 'transactions.D_TranProductQty as prodqty', 'transactions.D_TranProductPrice as prodprice')
            ->paginate(10);

        return view('admin.Receipt')->with('receipts', $receipts);
    }
}
