<?php

namespace App\Http\Controllers\Admin\Export;

use App\Exports\PaymentsExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Maatwebsite\Excel\BinaryFileResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(Request $request)
    {
        $validate = $request->validate([
            'exportFile' => 'required',
            'exportFormat' => 'required',
        ]);

        //Get extension for file
        $extension = $validate['exportFile'].Carbon::now()->toDateString().'.'.$validate['exportFormat'];

        return Excel::download(new PaymentsExport(), $extension);
    }
}
