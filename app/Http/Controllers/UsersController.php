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
// use PHPMailer\PHPMailer\Exception;


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
            $user->model = 'natural';
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
            // try {
            
            // Server settings
            $mail->SMTPDebug = 0;                                	// Enable verbose debug output
            $mail->isSMTP();                                     	// Set mailer to use SMTP
            $mail->Host = 'smtp.zoho.com';												// Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                              	// Enable SMTP authentication
            $mail->Username = 'support@fullyshops.com'; #Cambiar            // SMTP username
            $mail->Password = 'dMAjIr5V6H44';  #Cambiar            // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('support@fullyshops.com', 'Vitalic´s Support');  ## DESTINATARIO
            $mail->addAddress($user->email, $user->name);  ## DESTINATARIO
            #$mail->addAddress('his-her-email@gmail.com', 'Optional name');	// Add a recipient, Name is optional
            #$mail->addReplyTo('your-email@gmail.com', 'Mailer');
            #$mail->addCC('his-her-email@gmail.com');
            #$mail->addBCC('his-her-email@gmail.com');

            //Attachments (optional)
            // $mail->addAttachment('/var/tmp/file.tar.gz');			// Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');	// Optional name

            $html = "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
            <html>
            <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8' >
            <title>Mailto</title>
            <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet'>
            <style type='text/css'>
            html { -webkit-text-size-adjust: none; -ms-text-size-adjust: none;}
            
                @media only screen and (min-device-width: 750px) {
                    .table750 {width: 750px !important;}
                }
                @media only screen and (max-device-width: 750px), only screen and (max-width: 750px){
                  table[class='table750'] {width: 100% !important;}
                  .mob_b {width: 93% !important; max-width: 93% !important; min-width: 93% !important;}
                  .mob_b1 {width: 100% !important; max-width: 100% !important; min-width: 100% !important;}
                  .mob_left {text-align: left !important;}
                  .mob_soc {width: 50% !important; max-width: 50% !important; min-width: 50% !important;}
                  .mob_menu {width: 50% !important; max-width: 50% !important; min-width: 50% !important; box-shadow: inset -1px -1px 0 0 rgba(255, 255, 255, 0.2); }
                  .mob_center {text-align: center !important;}
                  .top_pad {height: 15px !important; max-height: 15px !important; min-height: 15px !important;}
                  .mob_pad {width: 15px !important; max-width: 15px !important; min-width: 15px !important;}
                  .mob_div {display: block !important;}
                 }
               @media only screen and (max-device-width: 550px), only screen and (max-width: 550px){
                  .mod_div {display: block !important;}
               }
                .table750 {width: 750px;}
            </style>
            </head>
            <body style='margin: 0; padding: 0;'>
            
            <table cellpadding='0' cellspacing='0' border='0' width='100%' style='background: #f3f3f3; min-width: 350px; font-size: 1px; line-height: normal;'>
                 <tr>
                   <td align='center' valign='top'>   			
                       <!--[if (gte mso 9)|(IE)]>
                     <table border='0' cellspacing='0' cellpadding='0'>
                     <tr><td align='center' valign='top' width='750'><![endif]-->
                       <table cellpadding='0' cellspacing='0' border='0' width='750' class='table750' style='width: 100%; max-width: 750px; min-width: 350px; background: #f3f3f3;'>
                           <tr>
                           <td class='mob_pad' width='25' style='width: 25px; max-width: 25px; min-width: 25px;'>&nbsp;</td>
                               <td align='center' valign='top' style='background: #ffffff;'>
            
                              <table cellpadding='0' cellspacing='0' border='0' width='100%' style='width: 100% !important; min-width: 100%; max-width: 100%; background: #f3f3f3;'>
                                 <tr>
                                    <td align='right' valign='top'>
                                       <div class='top_pad' style='height: 25px; line-height: 25px; font-size: 23px;'>&nbsp;</div>
                                    </td>
                                 </tr>
                              </table>
            
                              <table cellpadding='0' cellspacing='0' border='0' width='88%' style='width: 88% !important; min-width: 88%; max-width: 88%;'>
                                 <tr>
                                    <td align='left' valign='top'>
                                       <div style='height: 39px; line-height: 39px; font-size: 37px;'>&nbsp;</div>
                                       <a href='#' target='_blank' style='display: block; max-width: 128px;'>
                                          <img src='img/logo.png' alt='img' width='128' border='0' style='display: block; width: 128px;' />
                                       </a>
                                       <div style='height: 73px; line-height: 73px; font-size: 71px;'>&nbsp;</div>
                                    </td>
                                 </tr>
                              </table>
            
                              <table cellpadding='0' cellspacing='0' border='0' width='88%' style='width: 88% !important; min-width: 88%; max-width: 88%;'>
                                 <tr>
                                    <td align='left' valign='top'>
                                       <font face=''Source Sans Pro', sans-serif' color='#1a1a1a' style='font-size: 52px; line-height: 60px; font-weight: 300; letter-spacing: -1.5px;'>
                                          <span style='font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #1a1a1a; font-size: 52px; line-height: 60px; font-weight: 300; letter-spacing: -1.5px;'>Hey CONTACTO,</span>
                                       </font>
                                       <div style='height: 33px; line-height: 33px; font-size: 31px;'>&nbsp;</div>
                                       <font face=''Source Sans Pro', sans-serif' color='#585858' style='font-size: 24px; line-height: 32px;'>
                                          <span style='font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #585858; font-size: 24px; line-height: 32px;'>La empresa EMPRESA acaba de crear una cuenta a tu nombre en nuestro sistema.</span>
                                       </font>
                                       <div style='height: 20px; line-height: 20px; font-size: 18px;'>&nbsp;</div>
                                       <font face=''Source Sans Pro', sans-serif' color='#585858' style='font-size: 24px; line-height: 32px;'>
                                          <span style='font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #585858; font-size: 24px; line-height: 32px;'>Tu password para ingresar al sistema es la siguiente:<br>Tu Password: PASSWORD</span>
                                       </font>
                                       <div style='height: 33px; line-height: 33px; font-size: 31px;'>&nbsp;</div>
                                       <table class='mob_btn' cellpadding='0' cellspacing='0' border='0' style='background: #27cbcc; border-radius: 4px;'>
                                          <tr>
                                             <td align='center' valign='top'> 
                                                <a href='127.0.0.1:8000/login' target='_blank' style='display: block; border: 1px solid #27cbcc; border-radius: 4px; padding: 12px 23px; font-family: 'Source Sans Pro', Arial, Verdana, Tahoma, Geneva, sans-serif; color: #ffffff; font-size: 20px; line-height: 30px; text-decoration: none; white-space: nowrap; font-weight: 600;'>
                                                   <font face=''Source Sans Pro', sans-serif' color='#ffffff' style='font-size: 20px; line-height: 30px; text-decoration: none; white-space: nowrap; font-weight: 600;'>
                                                      <span style='font-family: 'Source Sans Pro', Arial, Verdana, Tahoma, Geneva, sans-serif; color: #ffffff; font-size: 20px; line-height: 30px; text-decoration: none; white-space: nowrap; font-weight: 600;'>Login</span>
                                                   </font>
                                                </a>
                                             </td>
                                          </tr>
                                       </table>
                                       <div style='height: 75px; line-height: 75px; font-size: 73px;'>&nbsp;</div>
                                    </td>
                                 </tr>
                              </table>
                              <table cellpadding='0' cellspacing='0' border='0' width='100%' style='width: 100% !important; min-width: 100%; max-width: 100%; background: #f3f3f3;'>
                                 <tr>
                                    <td align='center' valign='top'>
                                       <div style='height: 34px; line-height: 34px; font-size: 32px;'>&nbsp;</div>
                                       <table cellpadding='0' cellspacing='0' border='0' width='88%' style='width: 88% !important; min-width: 88%; max-width: 88%;'>
                                          <tr>
                                             <td align='center' valign='top'>
                                                <table cellpadding='0' cellspacing='0' border='0' width='78%' style='min-width: 300px;'>
                                                   <tr>
                                                      <td align='center' valign='top' width='23%'>                                             
                                                         <a href='#' target='_blank' style='font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #1a1a1a; font-size: 14px; line-height: 20px; text-decoration: none; white-space: nowrap; font-weight: bold;'>
                                                            <font face=''Source Sans Pro', sans-serif' color='#1a1a1a' style='font-size: 14px; line-height: 20px; text-decoration: none; white-space: nowrap; font-weight: bold;'>
                                                               <span style='font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #1a1a1a; font-size: 14px; line-height: 20px; text-decoration: none; white-space: nowrap; font-weight: bold;'>HELP&nbsp;CENTER</span>
                                                            </font>
                                                         </a>
                                                      </td>
                                                      <td align='center' valign='top' width='10%'>
                                                         <font face=''Source Sans Pro', sans-serif' color='#1a1a1a' style='font-size: 17px; line-height: 17px; font-weight: bold;'>
                                                            <span style='font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #1a1a1a; font-size: 17px; line-height: 17px; font-weight: bold;'>&bull;</span>
                                                         </font>
                                                      </td>
                                                      <td align='center' valign='top' width='23%'>
                                                         <a href='#' target='_blank' style='font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #1a1a1a; font-size: 14px; line-height: 20px; text-decoration: none; white-space: nowrap; font-weight: bold;'>
                                                            <font face=''Source Sans Pro', sans-serif' color='#1a1a1a' style='font-size: 14px; line-height: 20px; text-decoration: none; white-space: nowrap; font-weight: bold;'>
                                                               <span style='font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #1a1a1a; font-size: 14px; line-height: 20px; text-decoration: none; white-space: nowrap; font-weight: bold;'>SUPPORT&nbsp;24/7</span>
                                                            </font>
                                                         </a>
                                                      </td>
                                                      <td align='center' valign='top' width='10%'>
                                                         <font face=''Source Sans Pro', sans-serif' color='#1a1a1a' style='font-size: 17px; line-height: 17px; font-weight: bold;'>
                                                            <span style='font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #1a1a1a; font-size: 17px; line-height: 17px; font-weight: bold;'>&bull;</span>
                                                         </font>
                                                      </td>
                                                      <td align='center' valign='top' width='23%'>
                                                         <a href='#' target='_blank' style='font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #1a1a1a; font-size: 14px; line-height: 20px; text-decoration: none; white-space: nowrap; font-weight: bold;'>
                                                            <font face=''Source Sans Pro', sans-serif' color='#1a1a1a' style='font-size: 14px; line-height: 20px; text-decoration: none; white-space: nowrap; font-weight: bold;'>
                                                               <span style='font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #1a1a1a; font-size: 14px; line-height: 20px; text-decoration: none; white-space: nowrap; font-weight: bold;'>ACCOUNT</span>
                                                            </font>
                                                         </a>
                                                      </td>
                                                   </tr>
                                                </table>
                                                <div style='height: 34px; line-height: 34px; font-size: 32px;'>&nbsp;</div>
                                                <font face=''Source Sans Pro', sans-serif' color='#868686' style='font-size: 17px; line-height: 20px;'>
                                                   <span style='font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #868686; font-size: 17px; line-height: 20px;'>Copyright &copy; 2017 Mailto. All&nbsp;Rights&nbsp;Reserved. We&nbsp;appreciate&nbsp;you!</span>
                                                </font>
                                                <div style='height: 3px; line-height: 3px; font-size: 1px;'>&nbsp;</div>
                                                <font face=''Source Sans Pro', sans-serif' color='#1a1a1a' style='font-size: 17px; line-height: 20px;'>
                                                   <span style='font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #1a1a1a; font-size: 17px; line-height: 20px;'><a href='#' target='_blank' style='font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #1a1a1a; font-size: 17px; line-height: 20px; text-decoration: none;'>help@mailto.com</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href='#' target='_blank' style='font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #1a1a1a; font-size: 17px; line-height: 20px; text-decoration: none;'>1(800)232-90-26</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href='#' target='_blank' style='font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #1a1a1a; font-size: 17px; line-height: 20px; text-decoration: none;'>Unsubscribe</a></span>
                                                </font>
                                                <div style='height: 35px; line-height: 35px; font-size: 33px;'>&nbsp;</div>
                                                <table cellpadding='0' cellspacing='0' border='0'>
                                                   <tr>
                                                      <td align='center' valign='top'>
                                                         <a href='#' target='_blank' style='display: block; max-width: 19px;'>
                                                            <img src='img/soc_1.png' alt='img' width='19' border='0' style='display: block; width: 19px;' />
                                                         </a>
                                                      </td>
                                                      <td width='45' style='width: 45px; max-width: 45px; min-width: 45px;'>&nbsp;</td>
                                                      <td align='center' valign='top'>
                                                         <a href='#' target='_blank' style='display: block; max-width: 18px;'>
                                                            <img src='img/soc_2.png' alt='img' width='18' border='0' style='display: block; width: 18px;' />
                                                         </a>
                                                      </td>
                                                      <td width='45' style='width: 45px; max-width: 45px; min-width: 45px;'>&nbsp;</td>
                                                      <td align='center' valign='top'>
                                                         <a href='#' target='_blank' style='display: block; max-width: 21px;'>
                                                            <img src='img/soc_3.png' alt='img' width='21' border='0' style='display: block; width: 21px;' />
                                                         </a>
                                                      </td>
                                                      <td width='45' style='width: 45px; max-width: 45px; min-width: 45px;'>&nbsp;</td>
                                                      <td align='center' valign='top'>
                                                         <a href='#' target='_blank' style='display: block; max-width: 25px;'>
                                                            <img src='img/soc_4.png' alt='img' width='25' border='0' style='display: block; width: 25px;' />
                                                         </a>
                                                      </td>
                                                   </tr>
                                                </table>
                                                <div style='height: 35px; line-height: 35px; font-size: 33px;'>&nbsp;</div>
                                             </td>
                                          </tr>
                                       </table>
                                    </td>
                                 </tr>
                              </table>  
            
                           </td>
                           <td class='mob_pad' width='25' style='width: 25px; max-width: 25px; min-width: 25px;'>&nbsp;</td>
                        </tr>
                     </table>
                     <!--[if (gte mso 9)|(IE)]>
                     </td></tr>
                     </table><![endif]-->
                  </td>
               </tr>
            </table>
            </body>
            </html>"; ## SE CARGA LA PLANTILLA
            $html2 = str_replace('EMPRESA',$empresa->name, $html); ## SE CAMBIA EL NOMBRE DE LA EMPRESA
            $html3 = str_replace('CONTACTO',$user->name, $html2); ## SE CAMBIA EL NOMBRE DE EL USUARIO
            $htmlf = str_replace('PASSWORD',$password, $html3); ## SE INGRESA LA PASSWORD

            //Content
            $mail->isHTML(true); 					// Set email format to HTML
            $mail->Subject = 'Welcome to Vitalics';
            $mail->Body    = $htmlf;						// message

            if($mail->send()){
                return back()->with('message','Usuario registrado exitosamente');
            }else{

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
