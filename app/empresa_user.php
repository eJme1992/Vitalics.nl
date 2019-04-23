<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class empresa_user extends Model
{

	public $table= 'empresa_user';

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function empresa()
    {
    	return $this->belongsTo('App\Empresa','empresa_id');
    }
}
