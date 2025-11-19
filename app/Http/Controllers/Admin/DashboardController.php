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
        // Tu adaptes selon ce que tu as
        $productsCount   = Product::count();
        $enrollmentsCount = class_exists(Enrollment::class) ? Enrollment::count() : null;
        $paymentsCount    = class_exists(Payment::class) ? Payment::count() : null;

        return view('admin.dashboard', compact(
            'productsCount',
            'enrollmentsCount',
            'paymentsCount'
        ));
    }
}
