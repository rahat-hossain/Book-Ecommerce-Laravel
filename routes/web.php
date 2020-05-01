<?php

use App\Http\Controllers\FrontendController;

//FrontendController Routes
Route::get('/' , 'FrontendController@index');
Route::get('rahat' , 'FrontendController@rahat');
Route::get('contact' , 'FrontendController@contact');
Route::post('contact/submit' , 'FrontendController@contactsubmit');
Route::get('productdetails/{product_id}/{product_slug}' , 'FrontendController@productdetails');

Auth::routes(['verify' => true]);

//home controller route
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/contact/messages', 'HomeController@contactmessages')->name('contactmessages');
Route::get('/contact/upload/download/{file_name}', 'HomeController@contactuploaddownload')->name('contactuploaddownload');

//ProductController Routes
Route::prefix('product')->group(function(){
    Route::group(['middleware' => ['checkrole']], function() {
        Route::get('/', 'ProductController@product')->middleware('checkrole');
        Route::post('/insert', 'ProductController@productinsert');
        Route::get('/delete/{product_id}', 'ProductController@productdelete');
        Route::get('/restore/{product_id}', 'ProductController@productrestore');
        Route::get('/force/delete/{product_id}', 'ProductController@productforcedelete');
        Route::get('/edit/{product_id}', 'ProductController@productedit');
        Route::post('/edit', 'ProductController@productupdate');
    });
});

//CategoryController Routes
Route::resource('/category', 'CategoryController');

//UserController Routes
Route::get('/profile', 'UserController@profile')->name('profile');
Route::post('/password/change', 'UserController@passwordchange')->name('passwordchange');

//SliderController Routes
Route::get('/slider', 'SliderController@slider')->name('slider');
Route::post('/slider/insert', 'SliderController@sliderinsert')->name('sliderinsert');

//CartController Routes
Route::post('/add/to/cart', 'CartController@addtocart')->name('addtocart');

// Customer routes
Route::get('/customer/dashboard', 'CustomerController@customerdashboard')->name('customerdashboard');
