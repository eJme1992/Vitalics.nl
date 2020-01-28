<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class section extends Model
{
    public $inicio;

	 protected $fillable = [
    	    'cupos',
            'lugar',
            'estado',
            'descripcion',
             ];

 
    public function service()
    {
        return $this->belongsTo('App\Servicio','servicio_id');
    }

    public function fecha()
    {
        return $this->belongsTo('App\Fecha','seccion_id');
    }

     public function SetFecha($f)
    {
         $this->inicio = $f; 
    }

      public function GetFecha()
    {
        return $this->inicio;
    }
}
