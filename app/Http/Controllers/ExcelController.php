<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExcelController extends Controller
{
    //
    public function index()
    {
        $message = '';
        return view('empresa.excel',compact(['message']));
      
    }
}
