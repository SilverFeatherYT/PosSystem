<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Carbon;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction;

class TransactionController extends Controller
{
    public function viewTransaction()
    {

        Config::set('app.name', 'Transaction');

        $transaction = Transaction::paginate(10);
        $startDate = '';
        $endDate = '';
        $paymentType = '';
        $month = '';

        return view('admin.Transaction')
            ->with('transactions', $transaction)
            ->with('start_date', $startDate)
            ->with('end_date', $endDate)
            ->with('payment', $paymentType)
            ->with('month', $month);
    }

    public function transactionpaginate(Request $r)
    {
        Config::set('app.name', 'Transaction');

        if ($r->ajax()) {
            $query = Transaction::query();

            $startDate = $r->input('start_date');
            $endDate = $r->input('end_date');
            $month = $r->input('month');
            $paymentType = $r->input('payment');


            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            if ($month != 0) {
                $start_date = Carbon::create(null, $month, 1)->startOfMonth();
                $end_date = Carbon::create(null, $month, 1)->endOfMonth();

                $query->whereBetween('created_at', [$start_date, $end_date])->paginate(10);
            }

            if ($paymentType) {
                $query->where('D_TranPaymentType', $paymentType);
            }

            $transaction = $query->paginate(10);

            return view('Paginate.transaction')
                ->with('transactions', $transaction)
                ->with('start_date', $startDate)
                ->with('end_date', $endDate)
                ->with('month', $month)
                ->with('payment', $paymentType)
                ->render();
        }
    }

    public function filterDate(Request $r)
    {
        Config::set('app.name', 'Transaction');

        $startDate = $r->input('start_date');
        $endDate = $r->input('end_date');
        $paymentType = '';
        $month = '';

        $transaction = Transaction::whereBetween('created_at', [$startDate, $endDate])->paginate(10);

        $startDate = $r->filled('start_date') ? $startDate : '';
        $endDate = $r->filled('end_date') ? $endDate : '';

        return view('admin.Transaction')
            ->with('transactions', $transaction)
            ->with('start_date', $startDate)
            ->with('end_date', $endDate)
            ->with('payment', $paymentType)
            ->with('month', $month);
    }

    public function filterMonth(Request $r)
    {
        Config::set('app.name', 'Transaction');

        $month = $r->input('month');
        $paymentType = '';

        if ($month == 0) {
            return redirect()->route('viewTransaction');
        } else {
            // Determine the start and end dates for the selected month
            $start_date = Carbon::create(null, $month, 1)->startOfMonth();
            $end_date = Carbon::create(null, $month, 1)->endOfMonth();

            $transactions = Transaction::whereBetween('created_at', [$start_date, $end_date])->paginate(10);
        }

        $data = [
            'title' => 'Transaction',
            'date' => date('m/d/Y'),
            'transactions' => $transactions,
            'start_date' => $start_date ? $start_date->format('Y-m-d') : '',
            'end_date' => $end_date ? $end_date->format('Y-m-d') : '',
            'month' => $month,
            'payment' => $paymentType
        ];

        return view('admin.Transaction')->with($data);
    }

    public function filterPaymentType(Request $r)
    {
        Config::set('app.name', 'Transaction');

        $paymentType = $r->input('payment');
        $start_date = '';
        $end_date = '';
        $month = '';

        if ($paymentType == 0) {
            return redirect()->route('viewTransaction');
        } else {
            $transactions = Transaction::where('D_TranPaymentType', $paymentType)->paginate(10);
            $payment = $paymentType;
        }

        $data = [
            'title' => 'Transaction',
            'date' => date('m/d/Y'),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'transactions' => $transactions,
            'month' => $month,
            'payment' => $payment,

        ];

        return view('admin.Transaction')->with($data);
    }



    public function transactionPDF(Request $r)
    {
        $start_date = $r->input('start_date');
        $end_date = $r->input('end_date');
        $paymentType = $r->input('payment');
        $month = $r->input('month');

        $query = Transaction::query();

        if ($start_date && $end_date) {
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        if ($paymentType) {
            $query->where('D_TranPaymentType', $paymentType);
        }

        $transactions = $query->get();

        $data = [
            'title' => 'Transaction',
            'date' => date('m/d/Y'),
            'transactions' => $transactions,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'month' => $month,
            'payment' => $paymentType,
        ];

        $pdf = PDF::loadView('admin.pdf.Transactionpdf', $data);

        return $pdf->download('transaction_' . Carbon::now()->format('Y-m-d') . '.pdf');
    }
}
