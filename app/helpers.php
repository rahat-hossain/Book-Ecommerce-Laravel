<?php

function getCartAmount()
{
    $mac_address = exec('getmac'); 
    $mac = strtok($mac_address, ' '); 
    return $cart_amount = App\Cart::where('mac', $mac)->count();
}

function getCartProducts()
{
    $mac_address = exec('getmac'); 
    $mac = strtok($mac_address, ' '); 
    return $cart_amount = App\Cart::where('mac', $mac)->get();
}

function getCartTotalPrice()
{
    $mac_address = exec('getmac'); 
    $mac = strtok($mac_address, ' '); 
    $cart_products = App\Cart::where('mac', $mac)->get();
    $final_amount = 0;
    foreach($cart_products as $cart_product)
    {
        $final_amount += $cart_product->relationtoproducttable->product_price * $cart_product->quantity;
    }
    return $final_amount;
}