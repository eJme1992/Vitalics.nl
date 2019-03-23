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
        <div class="col-md-12">
            <a href="{{route('usuarios.index')}}" class="btn btn-success ">Nuevo usuario</a>
            <a href="{{route('excel.index')}}" class="btn btn-primary ">Cargar lista de empleados</a><br><br>
        </div>
        <div class="col-md-12">
            @include('usuarios.partials.message')
        </div>
            @foreach($usuarios as $user)
                @if($user->model != 'juridico')
                <div class="col-md-4">
                    <div class="card card-profile">
                        <div class="btn-group " style='float:right; '>
                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false"><span class="caret"></span>
                            </button>
                            <ul role="menu" class="dropdown-menu ">
                                <form action="{{route('usuarios.delete', $user->user_id)}}" method='POST'>
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class='btn'>Eliminar de la nomina</button>
                                </form>
                            </ul>
                        </div>
                        <img class="card-img-top img-fluid img-profile-list" src="{{url('/')}}{{$user->profile}}" alt="Card image"/>
                        <div class="card-body">
                        <h4 class="card-title">{{$user->name}}</h4>
                        <p class="card-text"><b>Cargo:</b> {{$user->cargo}} </p>
                        <a href="{{route('usuarios.show',$user->user_id)}}" class="btn btn-primary btn-profile-list">See Profile</a>
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
        
	</div>
</div>
@endsection