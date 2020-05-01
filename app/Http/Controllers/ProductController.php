<?php

namespace App\Http\Controllers;

use App\Category;
use App\ProductGallery;
use Illuminate\Http\Request;
use App\Product;
use Carbon\Carbon;
use Image;
use App\Http\Requests\ProductFormValidation;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        // $this->middleware('checkrole');
    }

    function product()
    {
        $products = Product::withTrashed()->get(); //only active products
        $categories = Category::all();
        return view('product.index', compact('products', 'categories'));
    }

    // ProductFormValidation
    function productinsert(Request $request)
    {
        $product_id = Product::insertGetId([
            'product_name' => $request->product_name,
            'product_short_description' => $request->product_short_description,
            'product_long_description' => $request->product_long_description,
            'category_id' => $request->category_id,
            'product_price' => $request->product_price,
            'product_quantity' => $request->product_quantity,
            'alert_quantity' => $request->alert_quantity,
            'created_at' => Carbon::now(),
        ]);
        //single image upload
        if($request->hasFile('product_photo'))
        {
            $product_photo = $request->file('product_photo');
            $new_name = $product_id.".".$product_photo->getClientOriginalExtension();
            $save_location = "public/uploads/products_photos/".$new_name;
            Image::make($product_photo)->resize(270, 340)->save(base_path($save_location));
            Product::findOrFail($product_id)->update([
                'product_photo' => $new_name
            ]);
        }
        //multiple image upload
        if($request->hasFile('product_gallery'))
        {
            $initial = 1;
            foreach($request->product_gallery as $single_product_gallery)
            {
                $new_name = $initial . "." . $single_product_gallery->getClientOriginalExtension();
                $initial++;
                $save_location = "public/uploads/product_gallery/" .$product_id."-". $new_name;
                Image::make($single_product_gallery)->resize(450, 565)->save(base_path($save_location));
                ProductGallery::insert([
                    'product_id' => $product_id,
                    'gallery_image' => $product_id."-". $new_name,
                    'created_at' => Carbon::now(),
                ]);
            }
        }
        return back()->with('status', 'Product inserted successfully!!');
    }

    function productdelete($product_id)
    {
        $product_name = Product::findOrFail($product_id)->product_name;
        Product::findOrFail($product_id)->delete();
        return back()->withDeletestatus($product_name . ' Deleted successfully!!');
    }

    function productrestore($product_id)
    {
        Product::withTrashed()->where('id', $product_id)->restore();
        $product_name = Product::findOrFail($product_id)->product_name;
        return back()->withRestorestatus($product_name . ' Restore successfully!!');
    }

    function productforcedelete($product_id)
    {
        Product::withTrashed()->where('id', $product_id)->forceDelete();
        return back();
    }

    function productedit($product_id)
    {
        $product_info = Product::findOrFail($product_id);
        $categories = Category::all();
        return view('product.edit' , compact('product_info', 'categories'));
    }

    function productupdate(ProductFormValidation $request)
    {
        if($request->hasFile('new_image'))
        {
            if(Product::findOrFail($request->product_id)->product_photo != 'defaultproductphoto.jpg')
            {
                unlink(base_path('public/uploads/products_photos/' . Product::findOrFail($request->product_id)->product_photo));
            }
            //---new photo upload code start
            $product_photo = $request->file('new_image');
            $new_name = $request->product_id.".".$product_photo->getClientOriginalExtension();
            $save_location = "public/uploads/products_photos/".$new_name;
            Image::make($product_photo)->resize(270, 340)->save(base_path($save_location));
            Product::findOrFail($request->product_id)->update([
                'product_photo' => $new_name
            ]);
            //---new photo upload code end
        }
        Product::findOrFail($request->product_id)->update([
            'product_name' => $request->product_name,
            'category_id' => $request->category_id,
            'product_price' => $request->product_price,
            'product_quantity' => $request->product_quantity,
            'alert_quantity' => $request->alert_quantity,
        ]);
        return redirect('product')->withEditstatus('Product Edited successfully!!');
    }

}
