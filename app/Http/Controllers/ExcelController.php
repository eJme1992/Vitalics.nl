<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;


class ExcelController extends Controller
{
    //
    public function index()
    {
        $message = '';
        return view('empresa.excel',compact(['message']));
      
    }

    public function importExcel(){

        $excel = Excel::import(new UsersImport, request()->file('excel'));

        dd($excel);
        return redirect('/')->with('success', 'All good!');
        
    }
}
