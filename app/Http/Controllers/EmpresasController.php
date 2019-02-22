<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FuncionesRepetitivas;
use App\Empresa;
use App\User;
class EmpresasController extends Controller
{


      public function __construct()
    {
       header('Origin: xxx.com');
       header('Access-Control-Allow-Origin:*');
       
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

     public function todasmisempresas()
    {
       $empresas = Empresa::all();
       return response()->json($empresas,200);
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
        
    }
    
    public function nuevaempresa(Request $request)
    {
        
        $validatedData = $request->validate(['file' => 'required|image', 'nombre' => 'required', 'rif' => 'required', 'phone' => 'required', 'address' => 'required', 'email' => 'required', 'password' => 'required', 'descripcion' => 'required']);

       if ($request->file('file')) {
                $file = $request->file('file');
                $name = time() . $file->getClientOriginalName();  
                $fn = new FuncionesRepetitivas();
                $name = $fn->limpiarCaracteresEspeciales($name);
                $file->move(public_path() . '/img/programa/', $name);
        }else{
          $name = public_path() . "/img/programa/profile.png";
        }

        $empresa = new Empresa();
        $empresa->nombre =       $request->input('nombre');
        $empresa->rif =          $request->input('rif');
        $empresa->descripcion =  $request->input('descripcion');
        $empresa->save();     

        $user = new User();
        $user->name = $request->input('nombre');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->model = "juridica";
        $user->phone = $request->input('phone');
        $user->address =$request->input('address');
        $user->profile = $name;
        $user->save();
        $user->empresa()->attach($empresa);

        return response()->json(['mensaje' => 'Registro creado con exito', 'status' => 'ok'], 200);
         
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
