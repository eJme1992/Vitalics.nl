<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\section;
use App\SectionUser;
use App\Servicio;
use Illuminate\Support\Facades\Auth;
use App\PuntosComprados;
use App\Fecha;

class EnrollController extends Controller
{
    public function enroll(Request $request)
    {
    	$points = Auth::user()->points->sum('puntos');

    	$section = section::findOrFail($request->section_id);

    	$placesSections = SectionUser::where('sections_id',$request->section_id)->count();

    	$existsEnroll = SectionUser::where('sections_id',$request->section_id)->where('user_id',$request->user_id)->exists();

        $fecha = Fecha::where('seccion_id',$request->section_id)->first();


    	//dd(['fecha' =>date('Y-m-d'), 'fecha de BD' => $fecha->fecha]);

        if ($fecha->fecha < date('Y-m-d')) { //si fecha de la seccion es mayor a la fecha actual
             return response()->json(['msg' => 'You can not register this section started on '.$fecha->fecha, 'status' => false], 422);
        }

    	if ($request->costo > $points) { // puntos del usuario y el costo
    		 return response()->json(['msg' => 'You do not have the necessary points to register', 'status' => false], 422);
    	}

    	if ($placesSections >= $section->cupos) { // cupos llenos
    		 return response()->json(['msg' => 'This section is full', 'status' => false], 422);
    	}

    	if ($existsEnroll) {
    		return response()->json(['msg' => 'You are already registered here :(', 'status' => false], 422);
    	}

    			$sectionUser = new SectionUser;
                $sectionUser->user_id = $request->user_id;
                $sectionUser->sections_id = $request->section_id;
                if ($sectionUser->save()) {
                	return response()->json(['msg' => 'You have registered!', 'status' => true], 200);
                }
    }
}
