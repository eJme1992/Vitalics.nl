<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Imports\UsersImport;


class ExcelController extends Controller
{
    //
    public function index()
    {
        $message = '';
        return view('empresa.excel',compact(['message']));
      
    }

    public function importExcel(){

        return redirect('/')->with('success', 'All good!');
        
    }
}
