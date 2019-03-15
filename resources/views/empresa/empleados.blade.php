@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="view-boton">
				<a href="#" class="view-boton-i"><i class="fa fa-list-ul"></i></a>
				<a class="view-boton-i" href="#"><<i class="fa fa-table"></i></a>
			</div>
		</div>
        @if(countEmpl(Auth::user()->id) > 0)
            @foreach($usuarios as $user)
                @if($user->model != 'juridico')
                <div class="col-md-4">
                    <div class="card card-profile">
                        <img class="card-img-top img-fluid img-profile-list" src="{{url('/')}}{{$user->profile}}" alt="Card image"/>
                        <div class="card-body">
                        <h4 class="card-title">{{$user->name}}</h4>
                        <p class="card-text"><b>Cargo:</b> {{$user->cargo}} </p>
                        <a href="{{route('usuarios.show',$user->id)}}" class="btn btn-primary btn-profile-list">See Profile</a>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
                
		<div class="col-md-12">
			<ul class="pagination justify-content-center">
			    <!-- <li class="page-item"><a class="page-link" href="javascript:void(0);">Previous</a></li>
			    <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
			    <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
			    <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
			    <li class="page-item"><a class="page-link" href="javascript:void(0);">Next</a></li> -->
                {!! $usuarios->render() !!}
            </ul>
		</div>
        @else
        <div class="col-md-12">
            <div class="alert alert-info alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                No hay empleados registrados.
            </div>
        </div>
        <div class="col-md-12">
            <a href="{{route('usuarios.index')}}" class="btn btn-success ">Nuevo usuario</a>
            <a href="#" class="btn btn-primary ">Cargar lista de empleados</a>
        </div>
        
        @endif  
	</div>
</div>
@endsection