<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;

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

    public function generate($id)
    {

        // Settings::setPdfRendererPath(base_path('vendor/dompdf/dompdf'));
        // Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
        // Settings::setZipClass(Settings::PCLZIP);
        Settings::setOutputEscapingEnabled(true);

        $template = new TemplateProcessor(storage_path('docx/customer.docx'));

        $customer = Customer::findOrFail($id);

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

        $filename_docx = Str::snake("$first_name$last_name.docx");

        $temp_docx_path = storage_path("temp/$filename_docx");

        $template->saveAs($temp_docx_path);

        return response()->download($temp_docx_path);

        // header("Content-Disposition: attachment; filename=$filename_docx");

        // $template->saveAs('php://output');
    }
}
