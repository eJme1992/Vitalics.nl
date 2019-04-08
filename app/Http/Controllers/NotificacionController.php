<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\User;
use App\Empresa;

class NotificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
          
        $user = User::where('email', $request->user)->first(); #Busco el email en la bd
        $empresa = Empresa::join('empresa_user', 'empresa_user.empresa_id', '=', 'empresas.id')
                ->join('users', 'users.id', '=', 'empresa_user.user_id')
                ->select('empresas.*')
                ->where('users.id', Auth::user()->id)
                ->where('users.model','juridico')->first(); 

        
        $mensaje = 'The company '.Auth::user()->name.' wants to invite you to be part of their employees.';
        $enlace = 'notificacion/'.$empresa->id;

        DB::table('notificacion')->insert([
            'usuario_id' => $user->id,
            'mensaje' => $mensaje,
            'estado' => 'enviado',
            'tipo' => 'invitacion',
            'url' => $enlace
        ]);

        $message = 'Invitation sent successfully';
        return back()->with('message', $message);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) #El id es el de la empresa
    {
        $empresa = Empresa::join('empresa_user', 'empresa_user.empresa_id', '=', 'empresas.id')
                        ->join('users', 'users.id', '=', 'empresa_user.user_id')
                        ->select('empresas.*')
                        ->where('empresas.id', $id)
                        ->where('users.model', 'juridico')
                        ->first(); #BUSCO LA EMPRESA
                    
        $notificacion = DB::table('notificacion')
                            ->where('usuario_id', Auth::user()->id)
                            ->where('estado','enviado')
                            ->first();

        return view('notificacion.mostrar',compact(['notificacion','empresa']));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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

        DB::table('notificacion')->where('id',$id)
        ->update([
            'estado' => 'visto'
        ]);

        if($request->respuesta != 'aceptar'){

            DB::table('empresa_user')->where([
                ['user_id', '=', Auth::user()->id],
                ['empresa_id', '=', $request->idEmpresa]
            ])->update([
                'estado' => 'rechazado'
            ]);

            return redirect()->route('home')->with('message','You have rejected the invitation.');

        }else{

            DB::table('empresa_user')->where([
                ['user_id', '=', Auth::user()->id],
                ['empresa_id', '=', $request->idEmpresa]
            ])->update([
                'estado' => 'activo'
            ]);

            return redirect()->route('home')->with('message','You have accepted the invitation.');

        }
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
