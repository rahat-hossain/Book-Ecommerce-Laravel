<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    function customerdashboard()
    {
      return view('customer.dashboard');
    }
}
