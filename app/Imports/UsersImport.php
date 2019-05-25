<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;
use DB;
use Auth;
use App\Mail\Email;


class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
         ## CREAR CONTRASE#A ALEATORIA
        // dd($row[0]);
        

        $email = User::where('email', $row[5])->count(); #Busco el email en la bd
        $uempresa = User::where('id', Auth::user()->id)->first(); #busco la empresa
        $empresaID = empresaID(Auth::user()->id);

        if ($email > 0) { #Verifico si se encontró una coincidencia
            $user = User::where('email', $row[5])->first(); #Lo encuentro

            #VEO SI ES EMPRESA
            if ($user->model == 'juridico') {
                $message = 'The logged in user is registered as a company';
                // return response()->json(['mensaje' => $message, 'status' => 'ok'], 200);
                return false;
            } else { #Si no es empresa
                $empresa_user = DB::table('empresa_user')
                    ->where(['user_id' => $user->id, 'empresa_id' => $empresaID])
                    ->count();
                if ($empresa_user > 0) { #Existe la relacion con la empresa??
                    DB::table('empresa_user')
                        ->where([
                            ['user_id', '=', $user->id], 
                            ['empresa_id','=', $empresaID],
                            ['estado', '!=', 'activo' ]
                            ]) ##Actualizo
                        ->update(['estado' => 'enviado']);

                    ##
                    ##   ENVIAR UNA INVITACION
                    ##
                    $mensaje = 'The company '.Auth::user()->name.' wants to invite you to be part of their employees.';
                    $enlace = 'notificacion/'.$empresaID;

                    $id = DB::table('notificacion')
                        ->where([
                            ['usuario_id', '=', $user->id],
                            ['url', '=', $enlace],

                        ])
                        ->update([
                            'estado' => 'enviado'
                        ]);

                    $message = 'The user already exists on your payroll';
                    return $user;

                } else { #Si no

                    DB::table('empresa_user')->insert(['user_id' => $user->id, ##
                    'empresa_id' => $empresaID, ##  CREO LA RELACION
                    'cargo' => $row[6], ##
                    'estado' => 'activo',
                    'puntos' => 0
                    ]);

                    ##
                    ##   ENVIAR UNA INVITACION
                    ##
                    $mensaje = 'The company '.Auth::user()->name.' wants to invite you to be part of their employees.';
                    $enlace = 'notificacion/'.$empresaID;

                    $id = DB::table('notificacion')->insertGetId([
                        'usuario_id' => $user->id,
                        'mensaje' => $mensaje,
                        'estado' => 'enviado',
                        'tipo' => 'solicitud',
                        'url' => $enlace
                    ]);
                    

                    $message = 'The user already exists. An invitation has been sent which must be accepted by the user to enter their payroll';
                    // return response()->json(['mensaje' => $message, 'status' => 'ok'], 200);
                    return $user;
                }
                
                // back()->with('message', $message)->with('user', $user->email);
                
            }
        } else { #Si no hay coincidencias

        
            // $faker = new Faker();
            // $password = $faker->asciify('*******'); ## CREAR CONTRASE#A ALEATORIA
            $password = 'secret'; ## CREAR CONTRASE#A ALEATORIA
            $user = new User();
            $user->name = $row[0];
            $user->email = $row[5];
            $user->phone = $row[2];
            $user->birthdate = $row[1];
            $user->model = 'natural';
            $user->address = $row[4];
            $user->password = Hash::make($password);
            $user->nationality = $row[3];
            $user->save();
            #Creo el nuevo usuario
            DB::table('empresa_user')->insert([
                'user_id' => $user->id, ##
                'empresa_id' => $empresaID, ##  CREO LA RELACION
                'cargo' => $row[6], ##
                'estado' => 'activo',
                'puntos' => 0
            ]);

            DB::table('puntos_comprados')->insert(['usuario_id' => $user->id, ##
            'puntos' => '0', 'created_at' => '2019-04-25', 'updated_at' => '2019-04-25']);
            
            ## AHORA, ENVIAR CORREO CON SU PASSWORD
            
            \Mail::to($row[5])->send(new Email($user, $uempresa, $password));
            // return response()->json(['mensaje' => $message, 'status' => 'ok'], 200);
            return $user;
        }
        
    }
}
