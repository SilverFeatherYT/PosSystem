<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    public function viewSalesReport(Request $r)
    {
        return view('admin.Report');
    }

    public function viewIncomeReport(Request $r)
    {
        return view('admin.Report');
    }

    public function viewTransactionReport(Request $r)
    {
        return view('admin.Report');
    }
}
