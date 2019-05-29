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


    public function sections(){
    	return  $this->belongsTo(section::class);
    }
}
