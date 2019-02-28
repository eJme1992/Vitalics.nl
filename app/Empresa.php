<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
      
    public function usuario(){
        return $this->belongsToMany('App\User', 'empresa_user');
    }

      protected $fillable = [
        'nombre', 'rif', 'descripcion'];

    }


