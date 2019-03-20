<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SectionsController extends Controller
{
    



     public function nuevosection(Request $request)
    {
        
        $validatedData = $request->validate(['cupos' => 'required', 'lugar' => 'required', 'descripcion' => 'required']);


        $section = new section();
        if(isset($request->input('empresa_id'))){
        $section->empresa_id   =  $request->input('empresa_id');
        }
        $section->cupos        =  $request->input('cupos');
        $section->lugar        =  $request->input('lugar');
        $section->estado       =  'activo';
        $section->descripcion  =  $request->input('descripcion');
        $section->save();     

     

        return response()->json(['mensaje' => 'Registro creado con exito', 'status' => 'ok'], 200);
         
    }
    public function versection($id)
    {
        $section = section::where('id',$id)->first();
        return response()->json(['datos' => $section, 'status' => 'ok'], 200);
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}