<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\section;
use App\SectionUser;
use App\Servicio;

class SectionsController extends Controller
{
    
    public function __construct()
    {
       header('Origin: xxx.com');
       header('Access-Control-Allow-Origin:*');     
    }

    public function todosmisseccioness($id) {
     $section = section::where('servicio_id',$id)->get();
     return response()->json(['datos' => $section, 'status' => 'ok'], 200);
    }


    public function nuevosection(Request $request)
    {
        
        $validatedData = $request->validate(['cupos' => 'required','lugar' => 'required', 'descripcion' => 'required']);

       
        $section = new section();
       
        if ($request->has('fecha')) {
        $section->fecha_id   =  $request->input('fecha');
        }
        $section->cupos        =  $request->input('cupos');
        $section->lugar        =  $request->input('lugar');
        $section->servicio_id  =  $request->input('servicio_id');
        $section->estado       =  'activo';
        $section->descripcion  =  $request->input('descripcion');
        $section->save();      
        return response()->json(['mensaje' => 'Record created with success', 'status' => 'ok'], 200);    
    }

    public function versecciones($id)
    {
        $section = section::where('id',$id)->first();
        return response()->json(['datos' => $section, 'status' => 'ok'], 200);
    }
    
    public function nuevoFecha(Request $request)
    {
        
    $validatedData = $request->validate(['fecha' => 'required', 'hora' => 'required', 'seccion_id ' => 'required', ]);


     if ($fecha < date('Y-m-d')) { 
    
        $fecha = new fecha();
        $fecha->fecha =          $request->input('fecha');
        $fecha->hora =           $request->input('hora');
        $fecha->seccion_id =     $request->input('seccion_id');
        $fecha->save();     
        return response()->json(['mensaje' => 'Registro creado con exito', 'status' => 'ok'], 200);
  
        }else{
            return response()->json(['mensaje' => 'Mail is duplicated', 'status' => '0'], 200);
        }
         
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
        //dd($request->all());

        $user = count($request->user);

        //dd($user);

        $servicio = Servicio::findOrFail($request->servicio_id);



        $section = new Section;
        $section->empresa_id = $request->empresa_id;
        $section->servicio_id = $request->servicio_id;
        $section->cupos = $request->cupos;
        $section->lugar = $request->lugar;
        $section->estado = $request->estado;
        $section->descripcion = $request->descripcion;
        if ($section->save()) {
            for ($i=0; $i < $user ; $i++) { 
                $sectionUser = new SectionUser;
                $sectionUser->user_id = $request->user[$i];
                $sectionUser->servicio_id = $request->servicio_id;
                $sectionUser->save();

                $sectionUser->restarPuntos($request->user[$i],$servicio->costo);
            }

            return response()->json(['msg' => 'Registrado Correctamente', 'status' => true], 200);

        }

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
