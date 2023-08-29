<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\RedeemMessage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function viewMain(Request $r)
    {
        $date = $r->input('date');
        $currentDate = Carbon::now()->format('Y-m-d');
        $shouldUpdateData = empty($date) || $date == $currentDate;


        // Update data if the date is empty or the same as the current date
        if ($shouldUpdateData) {
            // Update the date to the current date
            $date = $currentDate;

            // Query transactions based on the specified date or use the current date if not provided
            $query = Transaction::whereDate('created_at', $date);
            $product = $query->sum('D_TranProductQty');
            $count = $query->count();

            $rectotal = Receipt::whereDate('created_at', $date);
            $total = $rectotal->sum('D_RecTotal');

            // Query customers based on the specified date or use the current date if not provided
            $cusQuery = Customer::whereDate('created_at', $date);
            $cusTotal = $cusQuery->count();

            // Query redeem messages based on the specified date or use the current date if not provided
            $redeemCus = RedeemMessage::whereDate('created_at', $date)->get();

            $transactions = Transaction::whereDate('created_at', $date)->get();

            // Retrieve all the trading data if no date is selected
            $tradingData = DB::table('transactions')
                ->select(
                    DB::raw('DATE_FORMAT(created_at, "%b %Y") as month'),
                    DB::raw('SUM(D_TranProductPrice) as total')
                )
                ->groupBy('month')
                ->orderBy('created_at')
                ->pluck('total', 'month')
                ->toArray();

            $topproduct = Transaction::select('D_TranProductName', DB::raw('SUM(D_TranProductQty) as total_qty'))
                ->groupBy('D_TranProductName')
                ->orderByDesc('total_qty')
                ->limit(5)
                ->pluck('total_qty', 'D_TranProductName')
                ->toArray();

            // Update the application name
            Config::set('app.name', 'Main Page');
        } else {
            // Query based on the specified date or use the current date if not provided
            $query = Transaction::when($date, function ($query, $date) {
                return $query->whereDate('created_at', $date);
            });
            // Query customers based on the specified date or use the current date if not provided
            $cusQuery = Customer::when($date, function ($query, $date) {
                return $query->whereDate('created_at', $date);
            });
            $redeemCusQuery = RedeemMessage::when($date, function ($query, $date) {
                return $query->whereDate('created_at', $date);
            });
            $rectotal = Receipt::when($date, function ($rectotal, $date) {
                return $rectotal->whereDate('created_at', $date);
            });

            $endDate = Carbon::createFromFormat('Y-m-d', $date);
            $startDate = $endDate->copy()->subMonths(11);

            $tradingData = DB::table('transactions')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->select(
                    DB::raw('DATE_FORMAT(created_at, "%d %b %Y") as month'),
                    DB::raw('SUM(D_TranProductPrice) as total')
                )
                ->groupBy('month')
                ->orderBy('created_at')
                ->pluck('total', 'month')
                ->toArray();

            // Fetch the top 5 products based on sales quantity
            $topproduct = Transaction::select('D_TranProductName', DB::raw('SUM(D_TranProductQty) as total_qty'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('D_TranProductName')
                ->orderByDesc('total_qty')
                ->limit(5)
                ->pluck('total_qty', 'D_TranProductName')
                ->toArray();

            $product = $query->sum('D_TranProductQty');
            $total = $rectotal->sum('D_RecTotal');
            $count = $query->count();
            $cusTotal = $cusQuery->count();
            $redeemCus = $redeemCusQuery->get();
            $transactions = $query->get();

            Config::set('app.name', 'Main Page');
        }

        // Share data with the view
        View::share('total', $total);
        View::share('count', $count);
        View::share('cusTotal', $cusTotal);
        View::share('product', $product);
        View::share('tradingData', $tradingData);
        View::share('topproduct', $topproduct);

        return view('admin.MainPage')->with('transactions', $transactions)->with('redeemCus', $redeemCus);
    }

    public function filterMonth(Request $r)
    {
        Config::set('app.name', 'MainPage');

        $month = $r->input('month');
        $total = 0;
        $count = 0;
        $cusTotal = 0;

        // Query transactions based on the specified date or use the current date if not provided
        $query = Transaction::whereMonth('created_at', $month);
        $total = $query->sum('D_TranProductPrice');
        $product = $query->sum('D_TranProductQty');
        $count = $query->count();

        // Query customers based on the specified date or use the current date if not provided
        $cusQuery = Customer::whereMonth('created_at', $month);
        $cusTotal = $cusQuery->count();

        if ($month == 0) {
            return redirect()->route('viewMain');
        } else {
            // Determine the start and end dates for the selected month
            $currentYear = Carbon::now()->year;
            // Determine the start and end dates for the selected month within the current year
            $start_date = Carbon::create($currentYear, $month, 1)->startOfMonth();
            $end_date = Carbon::create($currentYear, $month, 1)->endOfMonth();

            $redeemCus = RedeemMessage::whereMonth('created_at', $month)
                ->whereYear('created_at', $currentYear)
                ->orderBy('created_at')
                ->get();
            $transactions = Transaction::whereMonth('created_at', $month)
                ->whereYear('created_at', $currentYear)
                ->orderBy('created_at')
                ->get();
        }

        $tradingData = DB::table('transactions')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%d %b %Y") as month'),
                DB::raw('SUM(D_TranProductPrice) as total')
            )
            ->groupBy('month')
            ->orderBy('created_at')
            ->pluck('total', 'month')
            ->toArray();

        $topproduct = Transaction::whereMonth('created_at', $month)
            ->whereYear('created_at', $currentYear)
            ->select('D_TranProductName', DB::raw('SUM(D_TranProductQty) as total_qty'))
            ->groupBy('D_TranProductName')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->pluck('total_qty', 'D_TranProductName')
            ->toArray();

        // Share data with the view
        View::share('total', $total);
        View::share('count', $count);
        View::share('product', $product);
        View::share('cusTotal', $cusTotal);
        View::share('tradingData', $tradingData);
        View::share('topproduct', $topproduct);

        return view('admin.MainPage')->with('transactions', $transactions)->with('redeemCus', $redeemCus);
    }

    public function filterYear(Request $r)
    {
        Config::set('app.name', 'MainPage');

        $year = $r->input('year');
        $yearStart = $year . '-01-01';
        $yearEnd = $year . '-12-31';

        $total = 0;
        $count = 0;
        $cusTotal = 0;

        // Query transactions based on the specified date or use the current date if not provided
        $query = Transaction::whereYear('created_at', $year);
        $total = $query->sum('D_TranProductPrice');
        $product = $query->sum('D_TranProductQty');
        $count = $query->count();

        // Query customers based on the specified date or use the current date if not provided
        $cusQuery = Customer::whereYear('created_at', $year);
        $cusTotal = $cusQuery->count();


        if ($year == 0) {
            return redirect()->route('viewMain');
        } else {
            $redeemCus = RedeemMessage::whereYear('created_at', $year)->get();
            $transactions = Transaction::whereYear('created_at', $year)->get();
        }

        $tradingData = DB::table('transactions')
            ->whereBetween('created_at', [$yearStart, $yearEnd])
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%b %Y") as month'),
                DB::raw('SUM(D_TranProductPrice) as total')
            )
            ->groupBy('month')
            ->orderBy('created_at')
            ->pluck('total', 'month')
            ->toArray();

        $topproduct = Transaction::whereYear('created_at', $year)
            ->whereYear('created_at', [$yearStart, $yearEnd])
            ->select('D_TranProductName', DB::raw('SUM(D_TranProductQty) as total_qty'))
            ->groupBy('D_TranProductName')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->pluck('total_qty', 'D_TranProductName')
            ->toArray();


        View::share('total', $total);
        View::share('count', $count);
        View::share('product', $product);
        View::share('cusTotal', $cusTotal);
        View::share('tradingData', $tradingData);
        View::share('topproduct', $topproduct);

        return view('admin.MainPage')->with('transactions', $transactions)->with('redeemCus', $redeemCus);
    }
}
