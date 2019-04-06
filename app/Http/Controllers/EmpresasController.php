<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FuncionesRepetitivas;
use App\Empresa;
use App\User;
use Auth;
use DB;

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
    public function index()## Mis empleados
    {
        $empresa = User::where(['id' => Auth::user()->id, 'model' => 'juridico'])->first();
        foreach($empresa->empresa as $e){
            $empresaID = $e->id;
        }
        // $e = Empresa::where('id', $empresaID)->first();
        // $usuarios = $e->usuario;

        // foreach($usuarios as $user){
        //     dd($user->pivot->cargo);
        // }
        $usuarios = User::
            join('empresa_user', 'empresa_user.user_id', '=', 'users.id')->
            join('empresas', 'empresas.id', '=', 'empresa_user.empresa_id')->
            select('users.*','empresa_user.*')->
            where('empresas.id', $empresaID)->
            where('users.model','natural')->
            where('empresa_user.estado','activo')->
            paginate(6);


        // dd($usuarios);

        return view('empresa.empleados', compact(['usuarios']));
    }

     public function todasmisempresas()
    {
      $empresas = User::
            join('empresa_user', 'empresa_user.user_id', '=', 'users.id')->
            join('empresas', 'empresas.id', '=', 'empresa_user.empresa_id')->
            select('users.*','empresa_user.*','empresas.id AS id_empresa','empresas.rif')->

            where('users.model','juridico')->get();
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
                $name = '/img/programa/'.$name;
        }else{
          $name = public_path() . "/img/programa/profile.png";
        }

        $empresa = new Empresa();
        $empresa->rif =          $request->input('rif');
        $empresa->descripcion =  $request->input('descripcion');
        $empresa->save();     

        $user = new User();
        $user->name = $request->input('nombre');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->model = "juridico";
        $user->phone = $request->input('phone');
        $user->address =$request->input('address');
        $user->profile = $name;
        $user->save();
        $user->empresa()->attach($empresa);

        return response()->json(['mensaje' => 'Registro creado con exito', 'status' => 'ok'], 200);
         
    }

    public function asignarPuntos(){
        $empresa = User::where(['id' => Auth::user()->id, 'model' => 'juridico'])->first();
        foreach($empresa->empresa as $e){
            $empresaID = $e->id;
        }
    
        $usuarios = User::
                join('empresa_user', 'empresa_user.user_id', '=', 'users.id')->
                join('empresas', 'empresas.id', '=', 'empresa_user.empresa_id')->
                select('users.*','empresa_user.*')->
                where('empresas.id', $empresaID)->
                where('users.model','natural')->
                where('empresa_user.estado','activo')->
                get();

        $puntos = DB::table('puntos_comprados')->where('usuario_id', Auth::user()->id)->first();

        return view('empresa.asignar-puntos', compact(['usuarios','puntos']));

    }

    public function savePuntos(Request $request){

        // dd($request->puntos[0]);

        // verifico si tengo puntos
        $total_puntos = 0;
        $puntos_empresa = DB::table('puntos_comprados')->where('usuario_id', Auth::user()->id)->first(); // busco los puntos de la empresa
        foreach($request->puntos as $puntos){
            $total_puntos+= $puntos;
        }
        if ($total_puntos > $puntos_empresa) {
            # Si el total de puntos es mayor a los que tiene la empresa
            # Los devuelvo con un error

            return back()->with('message','No tienes puntos suficientes para esta operación<br>Compra puntos <a href="#">aqui</a>');
        }else{
            # SI no continua normal

            

        }

        dd($total_puntos);
        // Los usuarios recibiran los puntos.

        // $puntos = DB::table('puntos_totales')->

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
