@extends('layouts.app')
@section('content')
    <div class="col-lg-2 col-md-2 col-sm-0"></div>
    <div class="col-md-8 col-sm-12">
        <div class="bs-example" data-example-id="simple-jumbotron">
            <div class="jumbotron text-center">
                <h1>Felicidades!</h1>
                <p>{{$notificacion->mensaje}}</p>
                <button class="btn btn-success">Aceptar</button>
                <button class="btn btn-danger">Rechazar</button>
            </div>
        </div>
    </div>

@endsection