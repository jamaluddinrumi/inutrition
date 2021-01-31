<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        $validator = Validator::make([$locale], ['required|in:id,en']);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        return (session(['locale' => $locale]));
    }
}
