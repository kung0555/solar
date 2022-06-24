<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Contract;

use PDF;

class PDFController extends Controller
{
    //
    public function generatePDF()
    {

        // $data = [
        //     'title' => "Welcome to ItSolutionStuff.com ทดสอบๆ",
        //     'date' => date('m/d/Y'),
        // ]; 
        $Contract = Contract::all();


        $pdf = PDF::loadView('myPDF', compact('Contract'));
        // return @$pdf->stream();
        // Storage::put('public/pdf/myPDF.pdf', $pdf->output());

        // $pdf->save('result.pdf');
        return $pdf->stream('result.pdf');
        // return $pdf->download('itsolutionstuff.pdf');
        // return @$pdf->download('myPDF.pdf');

        // PDF::loadHTML($pdf)->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf');

    }
}
