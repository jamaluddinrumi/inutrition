<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;

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
