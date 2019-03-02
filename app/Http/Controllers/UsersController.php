<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\FuncionesRepetitivas;
use DB;
use App\User;
use App\Empresa;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('usuarios.register');
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crearusuario(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'string|required',
            'email' => 'required|email',
            'birthdate' => 'required',
            'phone' => 'required|numeric',
            'estado' => 'required',
            'cargo' => 'required',
            'nationality' => 'required',
            'address' => 'required|string',
        ]);

        $email = User::where('email', $request->email)->count(); #Busco el email en la bd

        if($email > 0 ){ #Verifico si se encontró una coincidencia

            $user = User::where('email', $request->email)->first(); #Lo encuentro

            ##
            ##  Y HAGO EL PROCESO DE ENVIARLE UNA NOTIFICACION
            ##
            dd($user);
        }else{ #Si no hay coincidencias

            $user = new User();

            if ($request->file('profile')) {
                # guardo la foto con ruta relativa...
                $path = Storage::disk('public')->put('img/programa', $request->file('profile'));
    
                $user->profile = $path;
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->birthdate = $request->birthdate;
            $user->model = "natural";
            $user->address =$request->address;
            $user->password = Hash::make('123456');
            $user->nationality = $request->nationality;
            $user->save();
            #Creo el nuevo usuario

            ##
            ##  FALTA GUARDAR EL CARGO Y PEGARLO A LA EMPRESA
            ##

            dd($user);

        }

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
           return view('usuarios.user-create');

    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
       
       $validatedData = $request->validate(['name' => 'required', 'password' => 'required', 'birthdate' => 'required', 'model' => 'required', 'email' => 'required', 'nationality' => 'required', 'phone' => 'required', 'address' => 'required', ]);

       $Cliente->usuarios()->create([
           'nombre'     => $request->input('nombre'),
           'apellido'   => $request->input('apellido'),
           'cargo'      => $request->input('cargo'),
           'tipo'       => $request->input('tipo'),
           'correo'     => $request->input('correo'),
           'telefono'   => $request->input('telefono'),
        ]);
      return response()->json(['mensaje' => 'Registro creado con exito', 'status' => 'ok'], 200);
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

    $user = User::where('id',$id)->first();
    if($user->model=='juridico'){
    $empresa = Empresa::
                join('empresa_user', 'empresa_user.empresa_id', '=', 'empresas.id')->
                join('users', 'users.id', '=', 'empresa_user.empresa_id')->
                select('empresas.*')->
                where('users.id', $id)->
                where('users.model','juridico')->
                first(); 
                return view('usuarios.show', compact(['user','empresa']));      
     }else{
      $empresas = $user->empresa();
      return view('usuarios.show', compact(['user','empresas']));
     }           
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
         
        $user = User::where('id',$id)->first();

        

            if($user->model == 'natural'){
                
                $message = '';
                return view('usuarios.edit-user', compact(['user', 'message']));

            }elseif($user->model == 'juridico'){

                $user = User::findOrFail($id);
            
                $empresa = Empresa::
                join('empresa_user', 'empresa_user.empresa_id', '=', 'empresas.id')->
                join('users', 'users.id', '=', 'empresa_user.empresa_id')->
                select('empresas.*')->
                where('users.id', $id)->
                where('users.model','juridico')->
                first();

          
                $message = '';
                return view('usuarios.editar-empresa', compact(['user', 'message','empresa']));

            }
        

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

        $validatedData = $request->validate([
            'email' => 'unique:users|email',
        ]);

        $usuario = DB::table('users')->where('id',$id)->get();


        foreach($usuario as $user){
            if($user->model == 'natural'){

                if($request->password == ''){

                   
                   /* if ($request->file('profile')) {
                        # code...
                        $path = Storage::disk('public')->put('img', $request->file('profile'));
            
                        $profile = asset($path);
                        DB::table('users')->where('id',$id)
                            ->update([
                                'profile' => $profile,
                            ]);
                    }*/

                    if ($request->file('profile')) {
                    $file = $request->file('profile');
                    $name = time() . $file->getClientOriginalName();  
                    $fn = new FuncionesRepetitivas();
                    $name = $fn->limpiarCaracteresEspeciales($name);
                    $file->move(public_path() . '/img/programa/', $name);
                    $name = '/img/programa/'.$name;
                    DB::table('users')->where('id',$id)
                    ->update(['profile' => $name,]);
                    }

                    DB::table('users')->where('id',$id)
                        ->update([
                            'name' => $request->name,
                            'birthdate' => $request->birthdate,
                            'nationality' => $request->nationality,
                            'phone' => $request->phone,
                            'address' => $request->address,
                            'email' => $request->email,
                            'email' => $request->email,
                        ]);

                    return back();

                }else{
                    
                    $validatedData = $request->validate([
                        'password' => 'confirmed',
                    ]);

                    // if($request->password == $request->password2){

                    DB::table('users')->where('id',$id)
                    ->update([

                        'password' => Hash::make($request->password),

                    ]);
                    $message = 'Las contraseñas no coinciden';
                    return back()->with('message',$message);

                    // }else{

                        // $message = 'Las contraseñas no coinciden';
                        // return back()->with('message',$message);

                    // }
                   
                }



            }else{
                // EMPRESA

                 $user = User::findOrFail($id);
                 $empresa = $user->empresa;

                 foreach($empresa as $empresa){
                     $id_empresa = $empresa->id;
                 }
                 $empresa = Empresa::findOrFail($id_empresa);

                 if($request->password == ''){


                    if ($request->file('profile')) {
                    $file = $request->file('profile');
                    $name = time() . $file->getClientOriginalName();  
                    $fn = new FuncionesRepetitivas();
                    $name = $fn->limpiarCaracteresEspeciales($name);
                    $file->move(public_path() . '/img/programa/', $name);
                    $name = '/img/programa/'.$name;
                    DB::table('users')->where('id',$id)
                    ->update(['profile' => $name,]);
                    }
                    
                    // $empresa->rif =     $request->rif;
                    $empresa->descripcion =  $request->descripcion;
                    $empresa->save(); 

                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->phone = $request->phone;
                    $user->address =$request->address;
                    $user->nationality = $request->nationality;
                    $user->save();

                    return back();

                }else{

                    $validatedData = $request->validate([
                        'password' => 'confirmed',
                    ]);

                    // if($request->password == $request->password2){

                    DB::table('users')->where('id',$id)
                    ->update([

                        'password' => Hash::make($request->password),

                    ]);
                    $message = 'Contraseñas cambiadas exitosamente';
                    return back()->with('message',$message);

                    // }else{

                    //     $message = 'Las contraseñas no coinciden';
                    //     return back()->with('message',$message);

                    // }
                   
                }

            }
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
