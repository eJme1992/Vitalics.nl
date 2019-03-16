<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\FuncionesRepetitivas;
use DB;
use App\User;
use App\Empresa;
use Auth;
use Faker\Generator as Faker;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $message = '';
        return view('usuarios.register',compact(['message']));
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crearusuario(Request $request,  Faker $faker)
    {
        $validatedData = $request->validate([
            'name' => 'string|required',
            'email' => 'required|email',
            // 'birthdate' => 'required',
            'phone' => 'required|numeric',
            // 'estado' => 'required',
            'cargo' => 'required',
            'nationality' => 'required',
            'address' => 'required|string',
        ]);

        $email = User::where('email', $request->email)->count(); #Busco el email en la bd
        $empresa = User::where('id', Auth::user()->id)->first();
        foreach($empresa->empresa as $empresa){
            $empresaID = $empresa->id;
        }
        if($email > 0 ){ #Verifico si se encontró una coincidencia

            $user = User::where('email', $request->email)->first(); #Lo encuentro
            // $empresa = User::where('id', Auth::user()->id)->first();
            // foreach($empresa->empresa as $empresa){
            //     $empresaID = $empresa->id;
            // }
            DB::table('empresa_user')->insert([
                'user_id' => $user->id,         ##
                'empresa_id' => $empresaID,     ##  CREO LA RELACION
                'cargo' => $request->cargo,     ##
                'estado' => 'invitado'
            ]);

            // $empresa->empresa()->attach([
            //     'cargo' => $request->cargo,
            //     'estado' => 'invitado'
            // ]);

            ##
            ##  SE DEVUELVE UN MENSAJE PARA ENVIAR UNA INVITACION
            ##

            $message = 'existe';
            return back()->with('message', $message)->with('user', $user->email);

        }else{ #Si no hay coincidencias

            $password = $faker->bothify('???#?#??'); ## CREAR CONTRASE#A ALEATORIA

            $user = new User();

            if ($request->file('profile')) {
                # guardo la foto con ruta relativa...
                $path = Storage::disk('public')->put('img/programa', $request->file('profile'));
    
                $user->profile = '/'.$path;
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->birthdate = $request->birthdate;
            $user->model = "natural";
            $user->address =$request->address;
            $user->password = Hash::make($password);
            $user->nationality = $request->nationality;
            $user->save();
            #Creo el nuevo usuario

            DB::table('empresa_user')->insert([
                'user_id' => $user->id,         ##
                'empresa_id' => $empresaID,     ##  CREO LA RELACION
                'cargo' => $request->cargo,     ##
                'estado' => 'activo'
            ]);

            ## AHORA, ENVIAR CORREO CON SU PASSWORD
            $mail = new PHPMailer(true);                            // Passing `true` enables exceptions
  
            try {
                // Server settings
                $mail->SMTPDebug = 0;                                	// Enable verbose debug output
                $mail->isSMTP();                                     	// Set mailer to use SMTP
                $mail->Host = 'smtp.zoho.com';												// Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                              	// Enable SMTP authentication
                $mail->Username = 'edwin.jme@zoho.com'; #Cambiar            // SMTP username
                $mail->Password = 'Temporal92$';  #Cambiar            // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom($user->email, $user->name);  ## DESTINATARIO
                #$mail->addAddress('his-her-email@gmail.com', 'Optional name');	// Add a recipient, Name is optional
                #$mail->addReplyTo('your-email@gmail.com', 'Mailer');
                #$mail->addCC('his-her-email@gmail.com');
                #$mail->addBCC('his-her-email@gmail.com');

                //Attachments (optional)
                // $mail->addAttachment('/var/tmp/file.tar.gz');			// Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');	// Optional name

                $html = file_get_contents(asset('plantillas/email.html')); ## SE CARGA LA PLANTILLA
                $html2 = str_replace('EMPRESA',$empresa->name, $html); ## SE CAMBIA EL NOMBRE DE LA EMPRESA
                $html3 = str_replace('CONTACTO',$user->name, $html2); ## SE CAMBIA EL NOMBRE DE EL USUARIO
                $htmlf = str_replace('PASSWORD',$password, $html3); ## SE INGRESA LA PASSWORD

                //Content
                $mail->isHTML(true); 					// Set email format to HTML
                $mail->Subject = "Welcome to Vitalics";
                $mail->Body    = $htmlf;						// message

                $mail->send();
                return back()->with('message','Usuario registrado exitosamente');

            } catch (Exception $e) {

                return back()->with('error','Message could not be sent.');

            }
            

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
        if($user->model == 'juridico'){
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
            join('users', 'users.id', '=', 'empresa_user.user_id')->
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

                    $message = 'Datos actualizados exitosamente';
                    return back()->with('message', $message);

                }else{
                    
                    $validatedData = $request->validate([
                        'password' => 'confirmed',
                    ]);

                    // if($request->password == $request->password2){

                    DB::table('users')->where('id',$id)
                    ->update([

                        'password' => Hash::make($request->password),

                    ]);

                    $message = 'Contraseña guardada exitosamente';

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

                    $message = 'Datos actualizados exitosamente';
                    return back()->with('message', $message);

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
