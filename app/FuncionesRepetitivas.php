<?php

namespace App;



class FuncionesRepetitivas
{
    public function limpiarCaracteresEspeciales($string ){
    $string	  = str_replace(' ', '', $string);
    $string = htmlentities($string);
    $string = preg_replace('/\&(.)[^;]*;/', '\\1', $string);
    return $string;
    }
}
