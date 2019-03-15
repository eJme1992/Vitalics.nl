<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
      
    public function usuario(){
        return $this->belongsToMany('App\User', 'empresa_user')
                    ->withPivot('empresa_id','cargo','estado');
    }

      protected $fillable = [
        'nombre', 'rif', 'descripcion'];

    }


