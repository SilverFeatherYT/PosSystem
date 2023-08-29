<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Customer;
use App\Models\RedeemMessage;
use App\Models\Transaction;

class UserController extends Controller
{
    public function viewUser()
    {
        Config::set('app.name', 'User List');
        $users = User::orderBy('last_seen', 'DESC')->paginate(10);
        $customer = Customer::all();
        return view('admin.ListUser')->with('users', $users)->with('customer', $customer);
    }

    public function viewPayment()
    {
        return view('user.Payment');
    }


    public function addUser(Request $r)
    {
        $lastUserId = User::orderBy('user_id', 'desc')->first(); // Get the latest user
        $lastUserId = $lastUserId ? intval($lastUserId->user_id) : 0;
        $newUserId = str_pad($lastUserId + 1, 3, '0', STR_PAD_LEFT);

        $validated = Validator::make(
            $r->all(),
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string'],
                'phone' => ['required', 'string', 'min:9', 'max:12'],
                'role' => ['required'],
            ]

        );

        if (!$validated->passes()) {
            return response()->json(['status' => 0, 'error' => $validated->errors()->toArray()]);
        } else {
            $role = $r->input('role');

            $adduser = User::create([
                'user_id' => $newUserId,
                'name' => $r->name,
                'email' => $r->email,
                'password' => Hash::make($r['password']),
                'phone' => $r->phone,
                'D_role' => $role,
            ]);

            if ($adduser) {
                if ($role === '0') {
                    Customer::create([
                        'D_CusID' => $newUserId,
                        'D_CusPhone' => $r->phone,
                    ]);
                }
                return response()->json(['status' => 1, 'msg' => 'User Add Successful.']);
            }
        }

        return redirect()->back();
    }

    public function updateUser(Request $r)
    {
        $validated = Validator::make(
            $r->all(),
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'phone' => ['min:10', 'max:12'],
                'role' => ['required'],
            ]

        );

        if (!$validated->passes()) {
            return response()->json(['status' => 0, 'error' => $validated->errors()->toArray()]);
        } else {
            $role = $r->input('role');

            $user = User::find($r->id); //retrive data from user table
            $user->name = $r->name; //binding data with html input
            $user->email = $r->email;
            $user->password = Hash::make($r['password']);
            $user->phone = $r->phone;
            $user->D_role = $role;
            $user->save();

            if ($user->save()) {
                return response()->json(['status' => 1, 'msg' => 'User Update Successful.']);
            }
        }

        return redirect()->back();
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();

        $customer = Customer::where('D_CusID', $user->user_id)->first();

        if ($customer) {
            $customer->delete();
        }

        if ($user && $customer) {
            return redirect()->back()->with('status', 'User Delete Successful.');
        } else {
            return redirect()->back()->with('status', 'User Delete Failed.');
        }
    }

    public function deleteAllUser(Request $r)
    {
        // Get the selected user IDs from the request
        $selectedusers = json_decode($r->input('selectedusers'));
        $selectedcus = json_decode($r->input('selectedcus'));

        // Perform the deletion of selected users
        // You can use the user model and the delete method to delete multiple users at once
        $user = User::whereIn('id', $selectedusers)->delete();
        $customer = Customer::whereIn('D_CusID', $selectedcus)->delete();

        if ($user && $customer) {
            return redirect()->back()->with('status', 'Selected users have been deleted.');
        } else {
            return redirect()->back()->with('error', 'Fail to delete');
        }
    }



    public function viewProfile()
    {
        $user = auth()->user();

        $redeemMessages = RedeemMessage::paginate(4);

        $memberpoints = Transaction::where('D_TranCusName', $user->name)
            ->select('D_TranID', 'created_at', DB::raw('CAST(SUM(D_TranProductQty * D_TranProductPrice) / 10 AS UNSIGNED) as memberpoint'))
            ->groupBy('D_TranID', 'created_at')
            ->paginate(4);

        return view('Profile')->with('redeemMessages', $redeemMessages)->with('memberpoints', $memberpoints)->with('user', $user);
    }



    public function updateProfile(Request $r)
    {

        $user = Auth::user();
        $userName = $r['name']; //retrive data from user table

        if ($userName !== $user->name) {
            $existingUser = User::where('name', $userName)->first();

            // If an existing user with the new name is found, show an error
            if ($existingUser) {
                return redirect()->back()->with('error', 'Name already exists. Please choose a different name.');
            }
        }

        if (Hash::check($r['oldpassword'], $user->password)) {
            $user->name = $r->name;
            $user->phone = $r->phone;
            $user->password = Hash::make($r['newpassword']);

            $customer = Customer::where('D_CusID', $user->user_id)->first();
            if ($customer) {
                $customer->D_CusPhone = $r->phone;
                $customer->save();
            }

            $user->save();

            return redirect()->back()->with('status', 'Info Update Success');
        } else {
            return redirect()->back()->with('error', 'Password not correct');
        }
    }

    public function messagepaginate(Request $r)
    {
        if ($r->ajax()) {
            $redeemMessages = RedeemMessage::paginate(4);

            return view('Paginate.message')->with('redeemMessages', $redeemMessages)->render();
        }
    }
    public function pointpaginate(Request $r)
    {
        if ($r->ajax()) {
            $user = auth()->user();

            $memberpoints = Transaction::where('D_TranCusName', $user->name)
                ->select('D_TranID', 'created_at', DB::raw('CAST(SUM(D_TranProductQty * D_TranProductPrice) / 10 AS UNSIGNED) as memberpoint'))
                ->groupBy('D_TranID', 'created_at')
                ->paginate(4);

            return view('Paginate.point')->with('memberpoints', $memberpoints)->render();
        }
    }
}
