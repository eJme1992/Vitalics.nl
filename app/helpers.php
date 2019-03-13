<?php

use App\Notificacion;

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