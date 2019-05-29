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
     
    public function verempresa($id)
    {
        $Empresa = User::
            join('empresa_user', 'empresa_user.user_id', '=', 'users.id')->
            join('empresas', 'empresas.id', '=', 'empresa_user.empresa_id')->
            select('users.*','empresa_user.*','empresas.*')->
            where('empresas.id', $id)->
            where('users.model','juridico')->first();
            return response()->json(['datos' => $Empresa, 'status' => 'ok'], 200);
    }

    public function index()## Mis empleados
    {
        $empresaID = empresaID(Auth::user()->id);
        $usuarios = User::
            join('empresa_user', 'empresa_user.user_id', '=', 'users.id')->
            join('empresas', 'empresas.id', '=', 'empresa_user.empresa_id')->
            select('users.*','empresa_user.*')->
            where('empresas.id', $empresaID)->
            where('users.model','natural')->
            where('empresa_user.estado','activo')->
            paginate(6);
            return view('empresa.empleados', compact(['usuarios']));
    }

    public function lista_user_empresas($id)## Mis empleados
    {        
        $empresaID = empresaID($id);
        $usuarios = User::
            join('empresa_user', 'empresa_user.user_id', '=', 'users.id')->
            join('empresas', 'empresas.id', '=', 'empresa_user.empresa_id')->
            select('users.*','empresa_user.*')->
            where('empresas.id', $empresaID)->
            where('users.model','natural')->
            where('empresa_user.estado','activo')->
            get();
        return response()->json($usuarios,200);
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


    public function create()
    {
        //
    }

     public function store(Request $request)
    {
        
    }
    
    public function nuevaempresa(Request $request)
    { 
    $validatedData = $request->validate(['file' => 'required|image', 'nombre' => 'required', 'rif' => 'required', 'phone' => 'required', 'address' => 'required', 'email' => 'required', 'password' => 'required', 'descripcion' => 'required']);
    $email = User::where('email', $request->email)->count();
     if ($email < 1) { 
        
          $rif = Empresa::where('rif', $request->rif)->count();
          if ($rif < 1) { 

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
        DB::table('puntos_comprados')->insert(['usuario_id' => $user->id, ##
            'puntos' => '0']);
        return response()->json(['mensaje' => 'Registro creado con exito', 'status' => 'ok'], 200);
           }else{
           return response()->json(['mensaje' => "The Company's Trade register is duplicated", 'status' => '0'], 200);
        }
        }else{
            return response()->json(['mensaje' => 'Mail is duplicated', 'status' => '0'], 200);
        }      
    }

    public function asignarPuntos(){
        $empresaID = empresaID(Auth::user()->id);
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

        $empresaID = empresaID(Auth::user()->id); //Id de la empresa        
        $total_puntos = 0;
        $puntos_empresa = DB::table('puntos_comprados')->select('puntos')->where('usuario_id', Auth::user()->id)->first(); // busco los puntos de la empresa
        // dd($puntos_empresa->puntos);
        foreach($request->puntos as $puntos){
            $total_puntos+= $puntos;
        }
        if ($total_puntos > $puntos_empresa->puntos) {
            # Si el total de puntos es mayor a los que tiene la empresa
            # Los devuelvo con un error
            return back()->with('message','You do not have enough points for this operation<br>Buy <a href="#">here</a>');
        }else{
            # SI no, continua normal
            // Los usuarios recibiran los puntos.
            $i = 0; //recorre el array de puntos.
            foreach ($request->id_user as $usuario_id) {
                #Recorremos uno a uno los usuarios.
                $cu = DB::table('empresa_user')->where(['user_id' => $usuario_id, 'empresa_id' => $empresaID])->count(); //verificamos que la empresa no le haya asignado puntos anteriormente
                if ($cu > 0) { //Si existe, sumamos los nuevos puntos a los anteriores             
                    $usuario = DB::table('empresa_user')
                            ->where(['user_id' => $usuario_id, 'empresa_id' => $empresaID])
                            ->first(); //buscamos los puntos anterior
                    $p_anterior = $usuario->puntos;
                    $puntos = $p_anterior + $request->puntos[$i];
                    DB::table('empresa_user')
                        ->where(['user_id' => $usuario_id, 'empresa_id' => $empresaID])
                        ->update([
                            'puntos' => $puntos
                        ]);
                }
                $i++;
                DB::table('puntos_comprados')
                ->where('usuario_id', Auth::user()->id)
                ->update([
                    'puntos' => $puntos_empresa->puntos - $total_puntos
                ]);
            }
            // dd($total_puntos);       
            return back()->with('message','Points successfully assigned.');
        }
    }


    public function show($id)
    {
        //
    }

    public function filtro(Request $request){

        $empresaID = empresaID(Auth::user()->id);
        $usuarios = User::
            join('empresa_user', 'empresa_user.user_id', '=', 'users.id')->
            join('empresas', 'empresas.id', '=', 'empresa_user.empresa_id')->
            select('users.*','empresa_user.*')->
            where('empresas.id', $empresaID)->
            where('users.model','natural')->
            where('empresa_user.estado','activo')->
            where('users.name', 'like', $request->buscar.'%')->paginate(6);
        return view('empresa.empleados', compact(['usuarios']));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}