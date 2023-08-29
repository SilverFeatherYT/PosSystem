<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Customer;
use App\Models\RedeemItem;
use App\Models\RedeemMessage;

class RedeemController extends Controller
{
    public function viewRedeem()
    {

        Config::set('app.name', 'Redeem');

        $customerid = Auth::user()->user_id;

        $customers = Customer::where('D_CusID', $customerid)->first();

        $items = RedeemItem::paginate(8);

        return view('user.Redeem')->with('customer', $customers)->with('items', $items);
    }

    public function viewRedeemItem()
    {
        Config::set('app.name', 'RedeemItem');

        $items = RedeemItem::paginate(10);

        return view('admin.RedeemItem')->with('items', $items);
    }

    public function viewRedeemMessage()
    {
        Config::set('app.name', 'RedeemMessage');

        $messages = RedeemMessage::orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.RedeemMessage')->with('messages', $messages);
    }

    

    /**************************Admin Manage Redeem****************************/
    public function addRedeemItem(Request $r)
    {

        $validated = Validator::make(
            $r->all(),
            [
                'itemName' => 'required|unique:redeem_items,D_RedeemItemName',
                'itemQty' => 'required|numeric|min:1|max:999',
                'itemPoints' => 'required',
                'itemImage' => 'image|mimes:jpeg,png,gif,svg|max:2048',
            ],
            [
                'itemName.unique' => 'The item name is already exists.',

            ]

        );

        if (!$validated->passes()) {
            return response()->json(['status' => 0, 'error' => $validated->errors()->toArray()]);
            // return redirect()->back()->withErrors($validated)->withInput();
        } else {

            if ($r->file('itemImage') != '') { //if user upload something
                $image = $r->file('itemImage');
                $image->move('images', $image->getClientOriginalName()); //images is the location
                $imageName = $image->getClientOriginalName();
            } else {
                $imageName = null;
            }

            $addItem = RedeemItem::create([
                'D_RedeemItemID' => $r->itemID,
                'D_RedeemItemName' => $r->itemName,
                'D_RedeemItemQty' => $r->itemQty,
                'D_RedeemItemPoint' => $r->itemPoints,
                'D_RedeemItemImage' => $imageName,
                'D_RedeemItemStatus' => $r->itemStatus,
            ]);


            if ($addItem) {
                return response()->json(['status' => 1, 'msg' => 'Item Add Success']);
            }
        }

        return redirect()->back();
    }

    public function updateRedeemItem(Request $r)
    {
        $validated = Validator::make(
            $r->all(),
            [
                'itemName' => 'required',
                'itemQty' => 'required|numeric|min:1|max:999',
                'itemPoints' => 'required',
                'itemImage' => 'image|mimes:jpeg,png,gif,svg|max:2048',
            ]

        );

        if (!$validated->passes()) {
            return response()->json(['status' => 0, 'error' => $validated->errors()->toArray()]);
        } else {


            if ($r->file('itemImage') != '') {
                $image = $r->file('itemImage');
                $image->move('images', $image->getClientOriginalName()); //images is the location
                $imageName = $image->getClientOriginalName();
            } else {
                $imageName = null;
            }

            $item = RedeemItem::find($r->id); //retrive data from product table
            $item->D_RedeemItemID = $r->itemID; //binding data with html input
            $item->D_RedeemItemName = $r->itemName;
            $item->D_RedeemItemQty = $r->itemQty;
            $item->D_RedeemItemPoint = $r->itemPoints;
            $item->D_RedeemItemImage = $imageName;
            $item->D_RedeemItemStatus = $r->itemStatus;
            $item->save();

            if ($item->save()) {
                return response()->json(['status' => 1, 'msg' => 'Item Update Success']);
            }
        }

        return redirect()->back();
    }

    public function deleteRedeemItem($id)
    {
        $items = RedeemItem::find($id);

        if ($items->delete()) {
            return redirect()->back()->with('status', 'Items Delete Success');
        } else {
            return redirect()->back()->with('status', 'Items Delete Failed');
        }
    }

    public function deleteAllRedeemItem(Request $r)
    {
        // Get the selected product IDs from the request
        $selectedItems = json_decode($r->input('selectedItems'));

        // Perform the deletion of selected products
        // You can use the Item model and the delete method to delete multiple products at once
        RedeemItem::whereIn('id', $selectedItems)->delete();

        return redirect()->back()->with('status', 'Selected items have been deleted.');
    }


    /**************************Redeem Message****************************/
    public function updateMessage(Request $request)
    {
        $message = RedeemMessage::find($request->input('message_id'));

        if ($message) {
            $message->D_RedeemStatus = $request->input('status');
            $message->save();

            return redirect()->back()->with('status', 'Status updated successfully.');
        }

        return redirect()->back()->with('status', 'Failed to update status.');
    }

    /**************************Customer Redeem****************************/
    public function cusRedeemItem(Request $r)
    {
        $customerName = Auth::user()->user_id;
        $customers = Customer::where('D_CusID', $customerName)->first();
        $item = RedeemItem::find($r->item_id);

        if (!$customers) {
            return redirect()->back()->with('info', 'You are not authorized to redeem items.');
        }

        if ($item) {
            if ($item->D_RedeemItemStatus === 'Unavailable') {
                return back()->with('error', 'The item is unavailable now.');
            }
        }

        // Check if the customer has enough points and the item has enough quantity
        if ($customers->D_CusMemberPoint >= $item->D_RedeemItemPoint && $customers->D_CusMemberPoint >= ($r->quantity * $item->D_RedeemItemPoint)) {
            if ($item->D_RedeemItemQty <= 0 || $r->quantity > $item->D_RedeemItemQty) {
                return redirect()->back()->with('info', 'Item quantity not enough.');
            } else {

                // Deduct points from customer and quantity from item
                $customers->D_CusMemberPoint -= ($r->quantity * $item->D_RedeemItemPoint);
                $item->D_RedeemItemQty -= $r->quantity;

                // Update customer's message with redeemed item name
                $redeemMessage = new RedeemMessage();
                $redeemMessage->D_RedeemCusName = Auth::user()->name;
                $redeemMessage->D_RedeemCusMessage = Auth::user()->name . ' wants to redeem ' . $r->quantity . ' ' . $item->D_RedeemItemName;
                $redeemMessage->D_RedeemQuantity = $r->quantity;

                $redeemMessage->save();
                $customers->save();
                $item->save();

                return redirect()->back()->with('status', 'Item redeemed successfully.');
            }
        } else {
            return redirect()->back()->with('info', 'Insufficient points.');
        }
    }
}
