<?php

use App\Notificacion;
use App\User;

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