<?php
//pruebad
namespace App;

use Illuminate\Database\Eloquent\Model;
//ddd
class Empresa extends Model
{
      
    public function usuario(){
        return $this->belongsToMany('App\User', 'empresa_user')
                    ->withPivot('empresa_id','cargo','estado');
    }

    public function sections()
    {
    	return $this->hasMany('App\section','empresa_id');
    }


      protected $fillable = [
        'nombre', 'rif', 'descripcion'];

    }


