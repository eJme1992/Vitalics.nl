<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    //
    protected $table = 'notificacion';

    protected $fillable = [
        'usuario_id','mensaje','estado','tipo','url'
    ];
}
