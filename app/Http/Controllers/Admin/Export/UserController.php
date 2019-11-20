<?php

namespace App\Http\Controllers\Admin\Export;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
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
            'state' => 'string|nullable',
            'status' => 'integer|nullable',
            'startDate' => 'date|nullable',
            'endDate' => 'date|nullable',
            'volonteer' => 'integer|nullable',
            'delivery' => 'integer|nullable',
            'newspaper' => 'integer|nullable',
            'newsletter' => 'integer|nullable',
            'city' => 'string|nullable',
            'ageOperator' => 'string|nullable',
            'ageNumber' => 'integer|nullable',
            'phone' => 'string|nullable',
            'gift' => 'integer|nullable',
            'gender' => 'integer|nullable',
        ]);

        //Get extension for file
        $extension = $validate['exportFile'].Carbon::now()->toDateString().'.'.$validate['exportFormat'];

        //Build $settings for Query Builder in UsersExport
        return (new UsersExport($validate))->download($extension);
    }
}
