<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        $data = [
            'customers' => $customers,
            'title' => 'customer'
        ];
        return Inertia::render('Customer', $data);
    }
}
