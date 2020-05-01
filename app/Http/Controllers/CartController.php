<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CartController extends Controller
{
    function addtocart(Request $request)
    {
        // dd($_SERVER['REMOTE_ADDR']);
        // dd($request->ip());
        // dd(exec('getmac'));
        // for getting mac address
        $mac_address = exec('getmac'); 
        $mac = strtok($mac_address, ' '); 
        
        $available_quantity = Product::find($request->product_id)->product_quantity;
        $cart_info = Cart::where('mac', $mac)->where('product_id', $request->product_id)->first();

        //2nd part coding-2222222222
        if($cart_info)
        {
            //here old_cart_quantity holo cart table a oi product ta already koyta quantity add kora ache
            $old_cart_quantity = $cart_info->quantity;        
        }
        else
        {
            $old_cart_quantity = 0;
        }
        
        //3rd part of coding-33333333333
        if($available_quantity >= ($request->quantity + $old_cart_quantity))
        {
            //first part coding-111111111111
            if($cart_info)
            {
                //mac address and product same hole quantity just add korbe,new row hobe na tbl a
                Cart::where('mac', $mac)->where('product_id', $request->product_id)->increment('quantity', $request->quantity);
            }
            else
            {
                Cart::insert([
                    'mac' => $mac,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'created_at' => Carbon::now(),
                ]);
            }
        }
        else
        {
            $short_amount = $request->quantity- $available_quantity;
            return back()->with('errorstatus', 'not available quantity, shortage amount is '.$short_amount); 
        }
        
        return back()->with('successstatus', 'Product Added To Cart');
    }
}
