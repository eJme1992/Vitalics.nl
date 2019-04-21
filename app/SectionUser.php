<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PuntosComprados;
use Auth;

class SectionUser extends Model
{
	public $table = 'section_user';

   public function users()
    {
        return $this->hasMany('App\User');
    }

    public function restarPuntos($user,$costo)
    {
    	$query = PuntosComprados::where('usuario_id',$user)->first();

    	$query->puntos = $query->puntos - $costo;

    	$query->save();

    	return true;


    }

    public function restarPuntosEmpresa($costo,$empresa_id)
    {
        $query = PuntosComprados::where('usuario_id',$empresa_id)->first();

        $query->puntos = $query->puntos - $costo;

        $query->save();

        return true;


    }
}
