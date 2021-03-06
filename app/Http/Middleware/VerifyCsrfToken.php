<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'registrar_empresa',
        'registrar_servicio',
        'registrar_secciones',
        'registrar_fechas',
        'editar_usuario',
        'actualizarpuntos',
        'editar_secciones',
        'edit_servicio',
        'editar_usuario_pass'

    ];

}
