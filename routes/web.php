<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\RedirectIfAuthenticated;

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\RedeemController;
use App\Http\Controllers\ReceiptController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes(['verify' => true]);

Route::get('/', function () {
    return view('auth.login');
})->name('viewLogin')->middleware(RedirectIfAuthenticated::class);

Route::get('/spinner', function () {
    return view('spinner');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Google login
Route::get('auth/google', [App\Http\Controllers\SocialAuthController::class, 'redirectToProvider'])->name('google.login');
Route::get('auth/google/callback', [App\Http\Controllers\SocialAuthController::class, 'handleCallBack'])->name('google.login.callback');



//Pages only SuperAdmin can access
Route::group(['middleware' => ['auth', 'superAdmin', 'verified']], function () {

    //Home Controller
    Route::get('/MainPage', [App\Http\Controllers\HomeController::class, 'viewMain'])->name('viewMain');
    Route::get('/MainPage/filterYear', [App\Http\Controllers\HomeController::class, 'filterYear'])->name('Main.filterYear');
    Route::get('/MainPage/filterMonth', [App\Http\Controllers\HomeController::class, 'filterMonth'])->name('Main.filterMonth');


    //Product Controller
    Route::get('/Product', [App\Http\Controllers\ProductController::class, 'viewProduct'])->name('viewProduct');
    Route::post('/addProduct/store', [App\Http\Controllers\ProductController::class, 'addProduct'])->name('addProduct');
    Route::post('/update', [App\Http\Controllers\ProductController::class, 'updateProduct'])->name('updateProduct');
    Route::get('/delete/{id}', [App\Http\Controllers\ProductController::class, 'deleteProduct'])->name('deleteProduct');
    Route::delete('/deleteAll', [App\Http\Controllers\ProductController::class, 'deleteAllProduct'])->name('deleteAllProduct');
    Route::get('/getProductByBarcode/{barcode}', [App\Http\Controllers\ProductController::class, 'getProductByBarcode'])->name('getProductByBarcode');


    //Customer Controller
    Route::get('/Customer', [App\Http\Controllers\CustomerController::class, 'viewCustomer'])->name('viewCustomer');
    Route::post('/updateCustomer', [App\Http\Controllers\CustomerController::class, 'updateCustomer'])->name('updateCustomer');


    //Redeem Controller
    Route::get('/RedeemItem', [App\Http\Controllers\RedeemController::class, 'viewRedeemItem'])->name('viewRedeemItem');
    Route::post('/addItem/store', [App\Http\Controllers\RedeemController::class, 'addRedeemItem'])->name('addRedeemItem');
    Route::post('/updateItem', [App\Http\Controllers\RedeemController::class, 'updateRedeemItem'])->name('updateRedeemItem');
    Route::get('/deleteItem/{id}', [App\Http\Controllers\RedeemController::class, 'deleteRedeemItem'])->name('deleteRedeemItem');
    Route::delete('/deleteAllItem', [App\Http\Controllers\RedeemController::class, 'deleteAllRedeemItem'])->name('deleteAllItem');
    Route::get('/RedeemMessage', [App\Http\Controllers\RedeemController::class, 'viewRedeemMessage'])->name('viewRedeemMessage');
    Route::post('/updateMessage', [App\Http\Controllers\RedeemController::class, 'updateMessage'])->name('updateMessage');



    //User Controller
    Route::get('/ListUser', [App\Http\Controllers\UserController::class, 'viewUser'])->name('viewUser');
    Route::post('/addUser/store', [App\Http\Controllers\UserController::class, 'addUser'])->name('addUser');
    Route::post('/updateUser', [App\Http\Controllers\UserController::class, 'updateUser'])->name('updateUser');
    Route::get('/deleteUser/{id}', [App\Http\Controllers\UserController::class, 'deleteUser'])->name('deleteUser');
    Route::delete('/deleteAllUser', [App\Http\Controllers\UserController::class, 'deleteAllUser'])->name('deleteAllUser');


    //Transaction Controller
    Route::get('/Transaction', [App\Http\Controllers\TransactionController::class, 'viewTransaction'])->name('viewTransaction');
    Route::get('/filterDate', [App\Http\Controllers\TransactionController::class, 'filterDate'])->name('filterDate');
    Route::get('/filterMonth', [App\Http\Controllers\TransactionController::class, 'filterMonth'])->name('filterMonth');
    Route::get('/filterPaymentType', [App\Http\Controllers\TransactionController::class, 'filterPaymentType'])->name('filterPaymentType');
    Route::get('/transaction-pdf', [App\Http\Controllers\TransactionController::class, 'transactionPDF'])->name('transactionPDF');
    Route::post('/Transaction/Paginate', [App\Http\Controllers\TransactionController::class, 'transactionpaginate'])->name('transactionpaginate');

    
    //Invoice Controller
    Route::get('Invoice', [App\Http\Controllers\InvoiceController::class, 'viewInvoice'])->name('viewInvoice');
    Route::get('/filterInvoiceDate', [App\Http\Controllers\InvoiceController::class, 'filterInvoiceDate'])->name('filterInvoiceDate');
    Route::get('/filterInvoiceMonth', [App\Http\Controllers\InvoiceController::class, 'filterInvoiceMonth'])->name('filterInvoiceMonth');
    Route::post('/Invoice/Paginate', [App\Http\Controllers\InvoiceController::class, 'invoicepaginate'])->name('invoicepaginate');


    //Excel Controller
    Route::get('Transaction/export', [App\Http\Controllers\ExcelController::class, 'TransactionExport'])->name('Transaction.export');
    Route::get('Invoice/export', [App\Http\Controllers\ExcelController::class, 'InvoiceExport'])->name('Invoice.export');
    Route::get('Product/export', [App\Http\Controllers\ExcelController::class, 'ProductExport'])->name('Product.export');
    Route::post('Product/import', [App\Http\Controllers\ExcelController::class, 'ProductImport'])->name('Product.import');
    Route::get('Customer/export', [App\Http\Controllers\ExcelController::class, 'CustomerExport'])->name('Customer.export');
    Route::post('Customer/import', [App\Http\Controllers\ExcelController::class, 'CustomerImport'])->name('Customer.import');
});


//Pages only Admin can access
Route::group(['middleware' => ['auth', 'isAdmin', 'verified']], function () {

    //Pos Controller
    Route::get('/Pos', [App\Http\Controllers\PosController::class, 'viewPos'])->name('viewPos');
    Route::post('/Pos/store', [App\Http\Controllers\PosController::class, 'addPos'])->name('addPos');
    Route::post('/Pos/Paginate', [App\Http\Controllers\PosController::class, 'pospaginate'])->name('pospaginate');

    Route::get('/Receipt', [App\Http\Controllers\ReceiptController::class, 'viewReceipt'])->name('viewReceipt');
});

//Pages user can access
Route::group(['middleware' => ['auth', 'verified']], function () {


    Route::get('/Redeem', [App\Http\Controllers\RedeemController::class, 'viewRedeem'])->name('viewRedeem');
    Route::post('/customer/redeemItem', [App\Http\Controllers\RedeemController::class, 'cusRedeemItem'])->name('cusRedeemItem');

    Route::get('/Payment', [App\Http\Controllers\UserController::class, 'viewPayment'])->name('viewPayment');

    Route::get('/Profile', [App\Http\Controllers\UserController::class, 'viewProfile'])->name('viewProfile');
    Route::post('/EditProfile/Message/Paginate', [App\Http\Controllers\UserController::class, 'messagepaginate'])->name('messagepaginate');
    Route::post('/EditProfile/Point/Paginate', [App\Http\Controllers\UserController::class, 'pointpaginate'])->name('pointpaginate');
    Route::post('/updateProfile', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('updateProfile');
});
