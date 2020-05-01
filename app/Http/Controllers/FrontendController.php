<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use App\Contact;
use App\Slider;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FrontendController extends Controller
{
    function index()
    {
        $products = Product::all();
        $sliders = Slider::all();
        $categories = Category::all();
        return view('welcome', compact('products', 'sliders', 'categories', 'cart_amount'));
    }
    function rahat()
    {
        return view('rahat');
    }
    function contact()
    {
        return view('contact');
    }
    function contactsubmit(Request $request)
    {
        if($request->hasFile('upload_file'))
        {
            // insert code in one line
            $last_id = Contact::insertGetId($request->except('_token')+[
                'created_at' => Carbon::now()
            ]);
            $uploaded_file = $request->file('upload_file');
            $path = $request->file('upload_file')->storeAs(
                'contact_uploads', $last_id.'.'.$uploaded_file->getClientOriginalExtension()
            );
            Contact::find($last_id)->update([
                'upload_file' => $last_id.'.'.$uploaded_file->getClientOriginalExtension()
            ]);
            echo $path;
        }
        else
        {
            Contact::insertGetId($request->except('_token')+[
                'upload_file' => "No File",
                'created_at' => Carbon::now()
            ]);
        }
        // return back()->with('status','We received your message');
        return redirect('contact#contact_form')->with('status','We received your message');
        // print_r($request->all());
    }
    function productdetails($product_id, $product_slug)
    {
        $product_info = Product::find($product_id);
        $related_products = Product::where('category_id', $product_info->category_id)  //it will show info about same category products
                                    ->where('id', '!=', $product_id)  //it will remove which product is already open
                                    ->get();
        return view('productdetails', compact('product_info', 'related_products'));
    }

}
