<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fecha extends Model
{
    
    protected $fillable = [
    	    'fecha',
            'hora',
            'seccion_id',
             ];


    public function secciones(){
    	return  $this->belongsTo(section::class);
    }
}
