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

       if(Excel::import(new UsersImport, request()->file('excel'))){
            return back()->with('message', 'Successfully registered employees.');
       }else{
            return back()->with('message', 'An error has occurred');
       }

        
    }
}
