<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;


class ExcelController extends Controller
{
    //
    public function index()
    {
        $message = '';
        return view('empresa.excel',compact(['message']));
      
    }

    public function importExcel(Request $request){

        // dd(request()->file('excel'));

        $excel = Excel::load(new UsersImport, request()->file)

        // dd($excel);
        
        // return redirect('/')->with('success', 'All good!');
        
    }
}
