<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class section extends Model
{
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
}
