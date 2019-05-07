<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\section;
use App\SectionUser;
use App\Servicio;
use Illuminate\Support\Facades\Auth;
use App\PuntosComprados;

class EnrollController extends Controller
{
    public function enroll(Request $request)
    {
    	$points = Auth::user()->points->sum('puntos');

    	dd($points);

    }
}
