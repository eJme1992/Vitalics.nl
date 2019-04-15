<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class section extends Model
{
    public function service()
    {
        return $this->belongsTo('App\Servicio');
    }
}
