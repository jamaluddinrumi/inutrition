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

        Settings::setPdfRendererPath(base_path('vendor/dompdf/dompdf'));
        Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
        Settings::setZipClass(Settings::PCLZIP);

        $template = new TemplateProcessor(storage_path('docx/customer_details.docx'));

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
        // $filename_pdf = Str::snake("$first_name$last_name.pdf");

        $temp_docx_path = storage_path("temp/$filename_docx");

        ob_clean();
        $template->saveAs($temp_docx_path);

        // header("Content-Type: application/octet-stream");
        // header("Content-Type: application/pdf");
        // header("Content-Disposition: attachment; filename=$filename_pdf");

        // $temp_docx = IOFactory::load(storage_path('docx/customer_details.docx'));
        // $xmlWriter = IOFactory::createWriter($temp_docx, 'PDF');
        // $xmlWriter->save(storage_path("temp/$filename_pdf"), TRUE);
        // $xmlWriter->save('php//output');

        // return response()->download(storage_path("temp/$filename_pdf"));
        return response()->download($temp_docx_path);
        // $template->saveAs('php://output');


    }
}
