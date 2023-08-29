<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Exports\TransactionExport;
use App\Exports\CustomerExport;
use App\Exports\InvoiceExport;
use App\Exports\ProductExport;


use App\Imports\CustomerImport;
use App\Imports\ProductImport;
use App\Models\Receipt;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Transaction;

class ExcelController extends Controller
{

    /**
     * @return \Illuminate\Support\Collection
     */

    /**************************Transaction Excel****************************/
    public function TransactionExport(Request $r)
    {
        $start_date = $r->input('start_date');
        $end_date = $r->input('end_date');
        $paymentType = $r->input('payment');

        $query = Transaction::query();

        if ($start_date && $end_date) {
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        if ($paymentType) {
            $query->where('D_TranPaymentType', $paymentType);
        }

        $transactions = $query->get();

        $data = [
            'title' => 'Filtered Transactions',
            'transactions' => $transactions,
        ];

        return Excel::download(new TransactionExport($data), 'transactions.xlsx');
    }

    /**************************Invoice Excel****************************/
    public function InvoiceExport(Request $r)
    {
        $start_date = $r->input('start_date');
        $end_date = $r->input('end_date');

        $query = Receipt::query();

        if ($start_date && $end_date) {
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        $invoices = $query->get();

        $data = [
            'title' => 'Filtered Invoices',
            'invoices' => $invoices,
        ];

        return Excel::download(new InvoiceExport($data), 'invoice.xlsx');
    }

    /**************************Product Excel****************************/
    public function ProductImport(Request $r)
    {
        Excel::import(new ProductImport, request()->file('file'));
        return back();
    }

    public function ProductExport(Request $r)
    {
        return Excel::download(new ProductExport, 'Product.xlsx');
    }

    /**************************Customer Excel****************************/
    public function CustomerImport(Request $r)
    {
        Excel::import(new CustomerImport, request()->file('file'));
        return back();
    }

    public function CustomerExport(Request $r)
    {
        return Excel::download(new CustomerExport, 'Customer.xlsx');
    }
}
