@extends('layouts.app')
@section('content')
<div class="container">
        
	<div class="row">
        <div class="row panel-body">
        <div class="col-md-5" style="padding-top: 15.5px;">
            <a href="{{route('usuarios.index')}}" class="btn btn-success ">New user</a>
            <a href="{{route('excel.index')}}" class="btn btn-primary ">Load Employee List</a>
            <a href="{{route('asignar.puntos')}}" class="btn btn-success ">Assign points</a>
            <br><br>
        </div>
        <div class='col-md-4' style="padding-top:15.5px">
            <form action="{{route('user.filtro')}}" method="post">
                @csrf @method('POST')
                <div class="container">
                    </div>
                    <div class="col-md-6 ">
                        <input type="text" name="buscar" class='form-control' placeholder='Search'>
                    </div>
                    
                    <div class="col-md-6 ">
                        <button type="submit" class='btn btn-success'>Search <i class="fas fa-search"></i></button>
                    </div>
                </div>

            </form>
            <div class="view-boton float-right">
                <a href="#" class="view-boton-i" data-toggle="tooltip" title="View like details"><i class="fa fa-list-ul fa-lg"></i></a>
                <a class="view-boton-i" href="#" data-toggle="tooltip" title="View like icons"><i class="fa fa-table fa-lg"></i></a>
            </div>
		</div>
     
    </div>
    <hr>

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
                        </div><hr style="margin-top:40px">

                        
                        @if($user->profile== '')
                        <img class="card-img-top img-fluid img-profile-list img-circle"  width="156px" height="250px" src="{{url('/')}}/img/profile.png" alt="Card image"/>
                        @else
                        <img src="{{url('/')}}{{$user->profile}}"   alt="{{$user->name }}" class="img-circle card-img-top img-fluid img-profile-list"  width="156px" height="250px">
                        @endif
                        <div class="card-body">
                        <h4 class="card-title">{{$user->name}}</h4>
                        <p class="card-text"><b>Charge:</b> {{$user->cargo}} </p>
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