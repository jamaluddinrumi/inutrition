<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use App\Models\Nutrition;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\Settings;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use PhpOffice\PhpWord\TemplateProcessor;

class DashboardController extends Controller
{
    public function index()
    {

        $latestNutritions = \App\Models\Nutrition::take(10)->with('customer')->orderBy('updated_at', 'desc')->get()->reverse()->values();

        $latestCalories['value'] = [];
        $latestCalories['labels'] = [];

        foreach ($latestNutritions as $value) {
            array_push($latestCalories['value'], $value->calories);
            array_push($latestCalories['labels'], "{$value->customer->first_name} ({$value->calories})");
        }

        $customers = \App\Models\Customer::with('nutrition')->get();
        $users = \App\Models\User::get();;

        $data = [
            "title" => "dashboard",
            "customers" => $customers,
            "users" => $users,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'latestCalories' => $latestCalories,
        ];
        return Inertia::render("Dashboard", $data);
    }

    public function generate($id)
    {

        Settings::setOutputEscapingEnabled(true);

        $template = new TemplateProcessor(storage_path('docx/customer_nutrition.docx'));

        $nutrition = Nutrition::findOrFail($id)->load('customer');

        // dd($nutrition->calories);

        $calories = $nutrition->calories;
        $fat = $nutrition->fat;
        $carbs = $nutrition->carbs;
        $protein = $nutrition->protein;

        $template->setValue('calories', $calories);
        $template->setValue('fat', $fat);
        $template->setValue('carbs', $carbs);
        $template->setValue('protein', $protein);

        $customer = $nutrition->customer;

        $first_name = $customer->first_name;
        $last_name = $customer->last_name;
        $title = $customer->title;
        $city = $customer->city;
        $postcode = $customer->postcode;
        $street_address = $customer->street_address;
        $phone_number = $customer->phone_number;
        $email = $customer->email;
        $updated_at = $customer->updated_at;

        $template->setValue('first_name', $first_name);
        $template->setValue('last_name', $last_name);
        $template->setValue('title', $title);
        $template->setValue('city', $city);
        $template->setValue('postcode', $postcode);
        $template->setValue('street_address', $street_address);
        $template->setValue('phone_number', $phone_number);
        $template->setValue('email', $email);
        $template->setValue('updated_at', $updated_at);

        $filename_docx = Str::snake("$first_name$last_name customer_nutrition.docx");

        $temp_docx_path = storage_path("temp/$filename_docx");

        $template->saveAs($temp_docx_path);

        return response()->download($temp_docx_path);

        // header("Content-Disposition: attachment; filename=$filename_docx");

        // $template->saveAs('php://output');
    }
}
