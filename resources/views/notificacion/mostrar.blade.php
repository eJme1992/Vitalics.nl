@extends('layouts.app')
@section('content')
    <div class="col-lg-2 col-md-2 col-sm-0"></div>
    <div class="col-md-8 col-sm-12">
        <div class="bs-example" data-example-id="simple-jumbotron">
            <div class="jumbotron text-center">
                @if($notificacion->estado != 'recibido')
                <h1>¡Congratulations!</h1>
                <p>{{$notificacion->mensaje}}</p>

                <form method='POST' action="{{route('notificacion.update', $notificacion->id)}}">
                    @csrf
                    @method('PUT')
                    <input type='hidden' name='idEmpresa' value='{{$empresa->id}}'>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label >
                                        Accept
                                        <div class="iradio_flat-green" >
                                            <input type="radio" class="flat" name="respuesta" id="genderM" value="aceptar" required="" data-parsley-multiple="gender" >
                                            <ins class="iCheck-helper" ></ins>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label >
                                        Reject
                                        <div class="iradio_flat-green" >
                                            <input type="radio" class="flat" name="respuesta" id="genderF" value="rechazar" data-parsley-multiple="gender" >
                                            <ins class="iCheck-helper"></ins>
                                        </div>    
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    
                    <button type='submit' class="btn btn-success btn-lg">Send</button>
                </form>
                @else
                    <h2>This notification has already been processed</h2><br>
                    <a href='{{route("notificacion.index")}}' class='btn btn-info'>Back</a>
                @endif
            </div>
        </div>
    </div>

@endsection