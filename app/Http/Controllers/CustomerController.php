<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

use App\Models\Customer;

class CustomerController extends Controller
{

    public function viewCustomer()
    {

        Config::set('app.name', 'Customer');

        $customers = DB::table('customers')
            ->leftjoin('users', 'users.user_id', '=', 'customers.D_CusID')
            ->select('customers.*', 'users.id as user_id','users.name as name', 'users.email as email', 'users.phone as phone' , 'users.password as password')
            ->paginate(10);

        return view('admin.ListCustomer')->with('customers', $customers);
    }


    public function updateCustomer(Request $r)
    {
        $validated = Validator::make(
            $r->all(),
            [
                'cusMemberPoint' => 'required',
                // 'cusEmail' => 'required|email|unique:users,email,' . $r->user_id,
            ]

        );

        if (!$validated->passes()) {
            return response()->json(['status' => 0, 'error' => $validated->errors()->toArray()]);
        } else {

            $customer = Customer::find($r->id); //retrive data from product table
            $customer->D_CusMemberPoint = $r->cusMemberPoint;
            $customer->save(); 

            if ($customer->save()) {
                return response()->json(['status' => 1, 'msg' => 'Customer Update Success']);
            }
        }

        return redirect()->back();
    }

    // public function deleteCustomer($id)
    // {
    //     $customer = Customer::find($id);
    //     $user = User::where('user_id', $customer->D_CusID)->first();

    //     if ($customer->delete() && $user->delete()) {
    //         return redirect()->back()->with('status', 'Customer Delete Success');
    //     } else {
    //         return redirect()->back()->with('status', 'Customer Delete Failed');
    //     }
    // }

    // public function deleteAllCus(Request $r)
    // {
    //     // Get the selected product IDs from the request
    //     $selectedCustomers = json_decode($r->input('selectedCustomers'));

    //     // Perform the deletion of selected products
    //     // You can use the Product model and the delete method to delete multiple products at once
    //     Customer::whereIn('id', $selectedCustomers)->delete();
        
    //     $user = User::whereIn('id', $selectedCustomers)->delete();
    //     // dd($user);
    //     return redirect()->back()->with('status', 'Selected customer have been deleted.');
    // }
}
