<?php

namespace App\Http\Controllers\API;

use App\Models\Nutrition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NutritionResource;

class NutritionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $nutritions = Nutrition::all()->with('customer');

        // return response()->json($nutritions);

        return NutritionResource::collection(Nutrition::all()->load('customer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nutrition  $nutrition
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $nutrition = Nutrition::findOrFail($id)->with('customer');

        // return response()->json($nutrition);

        return new NutritionResource(Nutrition::findOrFail($id)->load('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nutrition  $nutrition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nutrition $nutrition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nutrition  $nutrition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nutrition $nutrition)
    {
        //
    }
}
