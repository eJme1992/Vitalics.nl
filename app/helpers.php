<?php

use App\Notificacion;
use App\User;
use PHPMailer\PHPMailer\PHPMailer;
use App\Servicio;

use PHPMailer\PHPMailer\Exception;

function notificaciones($id){

    
    if(countNoti($id) > 0){

        $notificacion = Notificacion::where(['usuario_id' => $id, 'estado' => 'enviado'])->get();

        return $notificacion;

    }else{
        return false;
    }

}

function countNoti($id){

    $n = Notificacion::where(['usuario_id' => $id, 'estado' => 'enviado'])->count();

    return $n;
}

function countEmpl($id){

    $empresa = User::where(['id' => $id, 'model' => 'juridico'])->first();
        foreach($empresa->empresa as $e){
            $empresaID = $e->id;
        }

    $n = User::
        join('empresa_user', 'empresa_user.user_id', '=', 'users.id')->
        join('empresas', 'empresas.id', '=', 'empresa_user.empresa_id')->
        select('users.*','empresa_user.*')->
        where('empresas.id', $empresaID)->
        where('users.model','natural')->count();

    return $n;
}

function enviarEmail(User $user, $empresaID, $password){
    
    $empresa = User::where('id', $empresaID)->first();

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
    $mail->setFrom('support@fullyshops.com', 'Support');  ## DESDE
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
                                    <span style='font-family: 'Source Sans Pro', Arial, Tahoma, Geneva, sans-serif; color: #585858; font-size: 24px; line-height: 32px;'><br>Tu Password: PASSWORD</span>
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
    $mail->Body    = $htmlf;				// message

    if($mail->send()){
        return true;
    }else{

        return false;

    }

}

// function typeServices(){
//     $servicios = Servicio::all()->groupBy('tipo');
//     // dd($servicios->toArray());
//     return $servicios->toArray();
// }

function converFecha($fecha){
    $f = explode('/', $fecha);
    $result = $f[2].'-'.$f[0].'-'.$f[1].' 00:00:00.000000';
    return $result;
}

function empresaID($id){
    $user = User::findOrFail($id);
    $empresa = $user->empresa;
    foreach ($empresa as $empresa) {
        $empresaID = $empresa->id;
    }
    return $empresaID;
}