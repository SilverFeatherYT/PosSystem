<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{

    public function viewInvoice()
    {
        Config::set('app.name', 'Invoice');

        $startDate = '';
        $endDate = '';
        $month = '';
        $transArray = DB::table('transactions')->pluck('D_TranID');

        $invoices = Receipt::paginate(10);

        $receiptsData = [];
        foreach ($transArray as $trans) {
            $receipts = DB::table('receipts')
                ->leftJoin('transactions', 'receipts.D_RecID', '=', 'transactions.D_TranID')
                ->select('receipts.*', 'transactions.D_TranCusName as cusName', 'transactions.D_TranProductName as prodname', 'transactions.D_TranProductQty as prodqty', 'transactions.D_TranProductPrice as prodprice', 'transactions.D_TranPaymentType as payment')
                ->where('receipts.D_RecID', $trans)
                ->get();

            $receiptsData[$trans] = $receipts;
        }

        return view('admin.Invoice')
            ->with('invoices', $invoices)
            ->with('start_date', $startDate)
            ->with('end_date', $endDate)
            ->with('month', $month)
            ->with('receiptsData', $receiptsData);
    }

    public function invoicepaginate(Request $r)
    {
        Config::set('app.name', 'Invoice');

        if ($r->ajax()) {
            $query = Receipt::query();

            $startDate = $r->input('start_date');
            $endDate = $r->input('end_date');
            $month = $r->input('month');

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            if ($month != 0) {
                $start_date = Carbon::create(null, $month, 1)->startOfMonth();
                $end_date = Carbon::create(null, $month, 1)->endOfMonth();

                $query->whereBetween('created_at', [$start_date, $end_date])->paginate(10);
            }

            $invoices = $query->paginate(10);


            $transArray = DB::table('transactions')->pluck('D_TranID');

            $receiptsData = [];
            foreach ($transArray as $trans) {
                $receipts = DB::table('receipts')
                    ->leftJoin('transactions', 'receipts.D_RecID', '=', 'transactions.D_TranID')
                    ->select('receipts.*', 'transactions.D_TranCusName as cusName', 'transactions.D_TranProductName as prodname', 'transactions.D_TranProductQty as prodqty', 'transactions.D_TranProductPrice as prodprice', 'transactions.D_TranPaymentType as payment')
                    ->where('receipts.D_RecID', $trans)
                    ->get();

                $receiptsData[$trans] = $receipts;
            }

            return view('Paginate.invoice')
                ->with('invoices', $invoices)
                ->with('start_date', $startDate)
                ->with('end_date', $endDate)
                ->with('month', $month)
                ->with('receiptsData', $receiptsData)
                ->render();
        }
    }

    public function filterInvoiceDate(Request $r)
    {
        Config::set('app.name', 'Invoice');

        $startDate = $r->input('start_date');
        $endDate = $r->input('end_date');
        $month = '';

        $invoices = Receipt::whereBetween('created_at', [$startDate, $endDate])->paginate(10);

        $startDate = $r->filled('start_date') ? $startDate : '';
        $endDate = $r->filled('end_date') ? $endDate : '';

        $transArray = DB::table('transactions')->pluck('D_TranID');
        $receiptsData = [];
        foreach ($transArray as $trans) {
            $receipts = DB::table('receipts')
                ->leftJoin('transactions', 'receipts.D_RecID', '=', 'transactions.D_TranID')
                ->select('receipts.*', 'transactions.D_TranCusName as cusName', 'transactions.D_TranProductName as prodname', 'transactions.D_TranProductQty as prodqty', 'transactions.D_TranProductPrice as prodprice', 'transactions.D_TranPaymentType as payment')
                ->where('receipts.D_RecID', $trans)
                ->get();

            $receiptsData[$trans] = $receipts;
        }

        return view('admin.Invoice')
            ->with('invoices', $invoices)
            ->with('start_date', $startDate)
            ->with('end_date', $endDate)
            ->with('month', $month)
            ->with('receiptsData', $receiptsData);
    }

    public function filterInvoiceMonth(Request $r)
    {
        Config::set('app.name', 'Invoice');

        $month = $r->input('month');

        if ($month == 0) {
            return redirect()->route('viewInvoice');
        } else {
            // Determine the start and end dates for the selected month
            $start_date = Carbon::create(null, $month, 1)->startOfMonth();
            $end_date = Carbon::create(null, $month, 1)->endOfMonth();

            $invoices = Receipt::whereBetween('created_at', [$start_date, $end_date])->paginate(10);
        }

        $transArray = DB::table('transactions')->pluck('D_TranID');
        $receiptsData = [];
        foreach ($transArray as $trans) {
            $receipts = DB::table('receipts')
                ->leftJoin('transactions', 'receipts.D_RecID', '=', 'transactions.D_TranID')
                ->select('receipts.*', 'transactions.D_TranCusName as cusName', 'transactions.D_TranProductName as prodname', 'transactions.D_TranProductQty as prodqty', 'transactions.D_TranProductPrice as prodprice', 'transactions.D_TranPaymentType as payment')
                ->where('receipts.D_RecID', $trans)
                ->get();

            $receiptsData[$trans] = $receipts;
        }

        $data = [
            'title' => 'Transaction',
            'date' => date('m/d/Y'),
            'invoices' => $invoices,
            'start_date' => $start_date ? $start_date->format('Y-m-d') : '',
            'end_date' => $end_date ? $end_date->format('Y-m-d') : '',
            'month' => $month,
        ];

        return view('admin.Invoice')->with($data)->with('receiptsData', $receiptsData);
    }
}
