<?php

namespace App\Http\Controllers\API;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CustomerResource::collection(Customer::all()->load('nutrition'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'title' => 'required',
            'city' => 'required',
            'postcode' => 'required',
            'streetAddress' => 'required',
            'phoneNumber' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json($validator->errors(), 400);
        }

        return new CustomerResource(Customer::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'title' => $request->title,
            'city' => $request->city,
            'postcode' => $request->postcode,
            'street_address' => $request->streetAddress,
            'phone_number' => $request->phoneNumber,
            'email' => $request->email,
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new CustomerResource(Customer::findOrFail($id)->load('nutrition'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            // 'firstName' => 'required',
            // 'lastName' => 'required',
            // 'title' => 'required',
            // 'city' => 'required',
            // 'postcode' => 'required',
            // 'streetAddress' => 'required',
            // 'phoneNumber' => 'required',
            // 'email' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json($validator->errors(), 400);
        }

        $customer = Customer::findOrFail($request->id);

        if ($customer) {

            $customer->id = $request->id;
            $customer->first_name = $request->firstName;
            $customer->last_name = $request->lastName;
            $customer->title = $request->title;
            $customer->city = $request->city;
            $customer->postcode = $request->postcode;
            $customer->street_address = $request->streetAddress;
            $customer->phone_number = $request->phoneNumber;
            $customer->email = $request->email;
            $customer->save();

            return new CustomerResource($customer);
        }

        return response()->json(false, 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        if ($customer) {

            if ($customer->nutrition) {

                $customer->nutrition->delete();
            }
            $deleted_customer_id = $customer->delete();

            if ($deleted_customer_id) {

                return response()->json($deleted_customer_id);
            }

            return response()->json(false, 404);
        }
    }
}
