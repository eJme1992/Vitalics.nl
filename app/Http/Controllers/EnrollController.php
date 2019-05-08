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

    	$section = section::findOrFail($request->section_id);

    	$placesSections = SectionUser::where('sections_id',$request->section_id)->count();

    	$existsEnroll = SectionUser::where('sections_id',$request->section_id)->where('user_id',$request->user_id)->exists();

    	//dd($placesSections);

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
