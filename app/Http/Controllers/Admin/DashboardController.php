<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Enrollment;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        {
        return view('admin.dashboard', [
            'productCount' => Product::count(),
            'enrollmentCount' => Enrollment::count(),
            'paymentCount' => Payment::count(),
        ]);
    }

    }
}
