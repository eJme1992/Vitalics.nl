<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\FuncionesRepetitivas;
use DB;
use App\User;
use App\Empresa;
use App\Mail\Email;
use Auth;
use Faker\Generator as Faker;
use App\Http\Requests\UserRequest;
class UsersController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $message = '';
        return view('usuarios.register', compact(['message']));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crearusuario(UserRequest $request, Faker $faker) {
        $email = User::where('email', $request->email)->count(); #Busco el email en la bd
        $uempresa = User::where('id', Auth::user()->id)->first(); #busco la empresa
        $empresaID = empresaID(Auth::user()->id);

        if ($email > 0) { #Verifico si se encontró una coincidencia
            $user = User::where('email', $request->email)->first(); #Lo encuentro
            
            #VEO SI ES EMPRESA
            if ($user->model == 'juridico') {
                $message = 'The logged in user is registered as a company';
                return response()->json(['mensaje' => $message, 'status' => 'ok'], 200);
                //return back()->with('message', $message);
            } else { #Si no es empresa
                $empresa_user = DB::table('empresa_user')->where(['user_id' => $user->id, 'empresa_id' => $empresaID])->count();
                if ($empresa_user > 0) { #Existe la relacion con la empresa??
                    DB::table('empresa_user')->where(['user_id' => $user->id, 'empresa_id' => $empresaID]) ##Actualizo
                    ->update(['estado' => 'invitado']);
                } else { #Si no
                    DB::table('empresa_user')->insert(['user_id' => $user->id, ##
                    'empresa_id' => $empresaID, ##  CREO LA RELACION
                    'cargo' => $request->cargo, ##
                    'estado' => 'invitado']);
                    $message = 'The user already exists. An invitation has been sent which must be accepted by the user to enter their payroll';
                    return response()->json(['mensaje' => $message, 'status' => 'ok'], 200);
                }
                ##
                ##  SE DEVUELVE UN MENSAJE PARA ENVIAR UNA INVITACION
                ##
                $message = 'The user already exists on your payroll';
                return response()->json(['mensaje' => $message, 'status' => 'ok'], 200);
                // back()->with('message', $message)->with('user', $user->email);
                
            }
        } else { #Si no hay coincidencias
            $password = $faker->bothify('???#?#??'); ## CREAR CONTRASE#A ALEATORIA
            $user = new User();
            if ($request->file('profile')) {
                # guardo la foto con ruta relativa...
                $path = Storage::disk('public')->put('img/programa', $request->file('profile'));
                $user->profile = '/' . $path;
            }
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->birthdate = $request->birthdate;
            $user->model = 'natural';
            $user->address = $request->address;
            $user->password = Hash::make($password);
            $user->nationality = $request->nationality;
            $user->save();
            #Creo el nuevo usuario
            DB::table('empresa_user')->insert(['user_id' => $user->id, ##
            'empresa_id' => $empresaID, ##  CREO LA RELACION
            'cargo' => $request->cargo, ##
            'estado' => 'activo']);
            ## AHORA, ENVIAR CORREO CON SU PASSWORD
            // if(enviarEmail($user, $uempresa->id, $password)){
            //     return back()->with('message','Usuario registrado exitosamente');
            // }else{
            //     return back()->with('error','Message could not be sent.');
            // }
            //\Mail::to('edwin.jme@hotmail.com')->send(new Email($user, $uempresa, $password));
            $message = 'The user has been created with existing';
            return response()->json(['mensaje' => $message, 'status' => 'ok'], 200);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('usuarios.user-create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if ($request->ajax()) {
            $validatedData = $request->validate(['name' => 'required', 'password' => 'required', 'birthdate' => 'required', 'model' => 'required', 'email' => 'required', 'nationality' => 'required', 'phone' => 'required', 'address' => 'required', ]);
            $Cliente->usuarios()->create(['nombre' => $request->input('nombre'), 'apellido' => $request->input('apellido'), 'cargo' => $request->input('cargo'), 'tipo' => $request->input('tipo'), 'correo' => $request->input('correo'), 'telefono' => $request->input('telefono'), ]);
            return response()->json(['mensaje' => 'Record created with success', 'status' => 'ok'], 200);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $user = User::where('id', $id)->first();
        if ($user->model == 'juridico') {
            $empresa = Empresa::join('empresa_user', 'empresa_user.empresa_id', '=', 'empresas.id')->join('users', 'users.id', '=', 'empresa_user.empresa_id')->select('empresas.*')->where('users.id', $id)->where('users.model', 'juridico')->first();
            return view('usuarios.show', compact(['user', 'empresa']));
        } else {
            $empresas = $user->empresa();
            return view('usuarios.show', compact(['user', 'empresas']));
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $user = User::where('id', $id)->first();
        if ($user->model == 'natural') {
            $message = '';
            return view('usuarios.edit-user', compact(['user', 'message']));
        } elseif ($user->model == 'juridico') {
            $user = User::findOrFail($id);
            $empresa = Empresa::join('empresa_user', 'empresa_user.empresa_id', '=', 'empresas.id')->join('users', 'users.id', '=', 'empresa_user.user_id')->select('empresas.*')->where('users.id', $id)->where('users.model', 'juridico')->first();
            $message = '';
            return view('usuarios.editar-empresa', compact(['user', 'message', 'empresa']));
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id) {
        $usuario = DB::table('users')->where('id', $id)->first();
        if ($usuario->model == 'natural') {
            if ($request->password == '') {
                if ($request->file('profile')) {
                    $file = $request->file('profile');
                    $name = time() . $file->getClientOriginalName();
                    $fn = new FuncionesRepetitivas();
                    $name = $fn->limpiarCaracteresEspeciales($name);
                    $file->move(public_path() . '/img/programa/', $name);
                    $name = '/img/programa/' . $name;
                    DB::table('users')->where('id', $id)->update(['profile' => $name, ]);
                }
                DB::table('users')->where('id', $id)->update(['name' => $request->name, 'birthdate' => $request->birthdate, 'nationality' => $request->nationality, 'phone' => $request->phone, 'address' => $request->address, 'email' => $request->email, 'email' => $request->email, ]);
                $message = 'Successfully updated data';
                return response()->json(['mensaje' => $message, 'status' => 'ok'], 200);
            } else {
                $validatedData = $request->validate(['password' => 'confirmed', ]);
                // if($request->password == $request->password2){
                DB::table('users')->where('id', $id)->update(['password' => Hash::make($request->password), ]);
                $message = 'Passwords successfully changed';
                return response()->json(['mensaje' => $message, 'status' => 'ok'], 200);
                //return back()->with('message',$message);
                // }else{
                // $message = 'Las contraseñas no coinciden';
                // return back()->with('message',$message);
                // }
                
            }
        } else {
            // EMPRESA
            $id_empresa = empresaID(Auth::user()->id); //Id de la empresa
            $user = User::findOrFail($id);
            $empresa = Empresa::findOrFail($id_empresa);
            if ($request->password == '') {
                if ($request->file('profile')) {
                    $file = $request->file('profile');
                    $name = time() . $file->getClientOriginalName();
                    $fn = new FuncionesRepetitivas();
                    $name = $fn->limpiarCaracteresEspeciales($name);
                    $file->move(public_path() . '/img/programa/', $name);
                    $name = '/img/programa/' . $name;
                    DB::table('users')->where('id', $id)->update(['profile' => $name, ]);
                }
                // $empresa->rif =     $request->rif;
                $empresa->descripcion = $request->descripcion;
                $empresa->save();
                $user->name = $request->name;
                // $user->email = $request->email;
                $user->phone = $request->phone;
                $user->address = $request->address;
                $user->nationality = $request->nationality;
                $user->save();
                $message = 'Successfully updated data';
                return response()->json(['mensaje' => $message, 'status' => 'ok'], 200);
            } else {
                $validatedData = $request->validate(['password' => 'confirmed', ]);
                // if($request->password == $request->password2){
                DB::table('users')->where('id', $id)->update(['password' => Hash::make($request->password), ]);
                $message = 'Passwords successfully changed';
                return response()->json(['mensaje' => $message, 'status' => 'ok'], 200);
                // }else{
                //     $message = 'Las contraseñas no coinciden';
                //     return back()->with('message',$message);
                // }
                
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id) {
        $empresaID = empresaID(Auth::user()->id); //Id de la empresa

        DB::table('empresa_user')->where(['user_id' => $id, 'empresa_id' => $empresaID])->update(['estado' => 'inactivo']);

        return back()->with('message', 'The employee is no longer on his payroll');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
        
    }
}
