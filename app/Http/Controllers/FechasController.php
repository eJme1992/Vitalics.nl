<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fecha;

class FechasController extends Controller
{
     public function __construct()
    {
       header('Origin: xxx.com');
       header('Access-Control-Allow-Origin:*');     
    }
     public function verfechas($id)
    {
        $fecha = fecha::where('id',$id)->first();
        return response()->json(['datos' => $fecha, 'status' => 'ok'], 200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function todosmisfechas($id) {
     $fecha = fecha::where('seccion_id',$id)->orderBy('fecha', 'desc')->get();
     return response()->json(['datos' => $fecha, 'status' => 'ok'], 200);
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
    public function nuevaFecha(Request $request)
    {
         

        if($request->input('fecha')>date("Y-m-d")){

        $Fechas = new Fecha();

       // $seccion =  $Fechas->sections();
       
        $Fechas->fecha       =    $request->input('fecha');
        $Fechas->hora        =    $request->input('hora');
        $Fechas->seccion_id  =    $request->input('seccion_id');
        $Fechas->save();
        $mensaje = 'Registered Date';
        return response()->json(['mensaje' => $mensaje, 'status' => 'ok'], 200);
        }else{
            $mensaje = 'To elected a date that already past';
            return response()->json(['mensaje' => $mensaje, 'status' => 0], 200);
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
