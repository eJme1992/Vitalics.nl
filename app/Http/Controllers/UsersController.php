<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
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
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
           return view ('usuarios.user-create');

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
        //
        return view('usuarios.show');
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
        $usuario = DB::table('users')->where('id',$id)->get();

        foreach($usuario as $user){

            if($user->model == 'natural'){
                
                $message = '';
                return view('usuarios.edit-user', compact(['usuario', 'message']));

            }elseif($user->model == 'juridico'){

                $user = User::findOrFail($id);
                $empresa = $user->empresa;

                $message = '';
                return view('usuarios.editar-empresa', compact(['usuario', 'message','empresa']));

            }
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
        //
        $usuario = DB::table('users')->where('id',$id)->get();

        foreach($usuario as $user){
            if($user->model == 'natural'){

                if($request->password == ''){


                    if ($request->file('profile')) {
                        # code...
                        $path = Storage::disk('public')->put('img', $request->file('profile'));
            
                        $profile = asset($path);
                        DB::table('users')->where('id',$id)
                            ->update([
                                'profile' => $profile,
                            ]);
                    }

                    DB::table('users')->where('id',$id)
                        ->update([
                            'name' => $request->name,
                            'birthdate' => $request->birthdate,
                            'nationality' => $request->nationality,
                            'phone' => $request->phone,
                            'address' => $request->address,
                            'email' => $request->email,
                        ]);

                    return back();

                }else{

                    if($request->password == $request->password2){

                        DB::table('users')->where('id',$id)
                        ->update([

                            'password' => Hash::make($request->password),

                        ]);
                        $message = 'Las contraseñas no coinciden';
                        return back()->with('message',$message);

                    }else{

                        $message = 'Las contraseñas no coinciden';
                        return back()->with('message',$message);

                    }
                   
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
                        # code...
                        $path = Storage::disk('public')->put('img/programa', $request->file('profile'));
            
                        $profile = asset($path);
                        DB::table('users')->where('id',$id)
                            ->update([
                                'profile' => $profile,
                            ]);
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

                    if($request->password == $request->password2){

                        DB::table('users')->where('id',$id)
                        ->update([

                            'password' => Hash::make($request->password),

                        ]);
                        $message = 'Las contraseñas no coinciden';
                        return back()->with('message',$message);

                    }else{

                        $message = 'Las contraseñas no coinciden';
                        return back()->with('message',$message);

                    }
                   
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
