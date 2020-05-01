<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use Image;
use App\Http\Requests\SliderValidation;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('checkrole');
    }
    function slider()
    {
        $sliders = Slider::all();
        return view('slider.index', compact('sliders'));
    }
    function sliderinsert(SliderValidation $request)
    {
        $info = Slider::create($request->except('_token'));
        if($request->hasFile('slider_photo'))
        {
            $slider_photo = $request->file('slider_photo');
            $new_name = $info->id.".".$slider_photo->getClientOriginalExtension();
            $save_location = "public/uploads/sliders_photos/".$new_name;
            Image::make($slider_photo)->resize(1920, 950)->save(base_path($save_location));
            $info->slider_photo = $new_name;
            $info->save();
        }
        return back()->with('status', 'Slider Title & Photo insert successfully!!');
    }
}
