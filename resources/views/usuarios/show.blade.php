@extends('layouts.app')
@section('content')
<div class="container"  style=' padding:0px;'>
    <div class="row">
        @include('usuarios.partials.message')
    </div>
    <div class="row " style='background-color: #424E5C;'>
        <div class="col-md-3" >
            @if($user->profile == '')
                <img src="{{url('/')}}/img/profile.png" class="img-prueba img-circle"  id="img-prueba">
            @else
                <img src="{{url('/')}}{{$user->profile}}"   class="img-prueba img-circle" id="img-prueba">
            @endif
        </div>
        <div class="col-md-9 " style='border-left:#B6BEC9 2px solid;'>
            @if($user->model=='natural')
            <div class="container" style='color:white; padding-left:10px;'>
                <div class="row">
                   
                        <h2 style="display: inline;">{{$user->name}}</h2> 
                        @if(Auth::user()->id===$user->id)
                        <a style="margin-bottom: 13px;" href="{{url('usuarios/'.$user->id.'/edit')}}" class="btn btn-warning btn-xs">Edit</a><br>
                        @endif
                </div>
                <div class="row" style='font-size:17px; '>
                    <div class="col-md-6">
                        Birthdate: {{$user->birthdate}}<br>
                        Nationality: {{$user->nationality}}<br>
                    </div>
                    <div class="col-md-6">
                        Phone: {{$user->phone}}<br>
                        Email: {{$user->email}}<br>
                        
                    </div>
                </div>
                <div class="row " style='font-size:17px;'>
                    <div class='col-md-12'>Direccion: {{$user->address}}</div>
                </div>
            </div>
           @else
            <div class="container" style='color:white; padding-left:10px;'>
                <div class="row">
                   
                 <h2 style="display:inline;">{{$user->name}} </h2> <span>- {{$user->descripcion}}</span><br><br>
                    
                </div>
                <div class="row" style='font-size:17px; '>
                    <div class="col-md-6">
                        RIF : {{$user->rif}}<hr>

                        
                        Phone : {{$user->phone}}<br>
                        Email : {{$user->email}}<br>
                    </div>
                    <div class="col-md-6">
                        Nationality : {{$user->nationality}}<hr>
                        Address :  {{$user->address}}                   
                    </div>
                </div>
                <div class="row " style='font-size:17px;'>
                
                </div>
            </div>
        </div>


           @endif



        </div>

    </div>
    <div class="row" >
        <div class="col-md-8">
            @if($user->model == 'juridico')
            <center>
                <h3 class='mg-b' style='padding-top:10px;'>OPEN SECTIONS</h3>
            </center>
                @forelse($sections as $section)
                <div class="x_panel">
                    <div class="x_content">
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">quotas</p>
                                <p class="day">{{$section->cupos}}</p>
                            </a>
                            <div class="media-body">
                            <a class="title" href="#">{{$section->estado}}</a>
                            <p>{{$section->descripcion}}</p>
                            <em>{{$section->lugar}}</em>
                            
                            </div>
                        </article>
                    </div>
                </div>
                @empty
                <div class="x_panel">
                    <div class="x_content">
                        <article class="media event">
                            <div class="media-body">
                                <a class="title" href="#">You have not registered any section</a>
                            </div>
                        </article>
                    </div>
                </div>
                @endforelse
            @else
            <center>
                <h3 class='mg-b' style='padding-top:10px;'>REGISTERED SERVICES</h3>
            </center>
            @forelse($sections as $section)
                <div class="x_panel">
                    <div class="x_content">
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month" style='font-size: 10px;'>Sessions</p>
                                <p class="day">{{$section->sesiones}}</p>
                            </a>
                            <div class="media-body">
                            <a class="title" href="#">{{$section->estado}}</a>
                            <p>{{$section->descripcion}}</p>
                            <em>{{$section->nombre}}</em>
                            
                            </div>
                        </article>
                    </div>
                </div>
            @empty
                <div class="x_panel">
                    <div class="x_content">
                        <article class="media event">
                            <div class="media-body">
                                <a class="title" href="#">You have not registered any service</a>
                            </div>
                        </article>
                    </div>
                </div>
            @endforelse
            @endif
            {{$sections->render()}}
            
        </div>
        <div class="col-md-4" style='background-color:#F4A958; height:70%;'>
            <center>
                <h3 class='mg-b' style='padding-top:10px;'>POINTS</h3>
            </center>

            <div>
                
                <ul class="list-unstyled top_profiles scroll-view">
                       <li class="media event">
                        <a class="pull-left border-blue profile_thumb">
                            <i class="fa fa-user blue"></i>
                        </a>
                    <div class="media-body">
                         <a class="title" href="#">Total points </a>
                        <h3><strong>
                        @if($user->model == 'juridico')
                            @if($puntos_comprados)
                                {{$puntos_comprados->puntos }}
                            @else
                                0
                            @endif
                        @else
                            @if($puntos_comprados && $puntos_otorgados)
                                {{$puntos_comprados->puntos + $puntos_otorgados->puntos}}
                            @elseif($puntos_comprados && !$puntos_otorgados)
                                {{$puntos_comprados->puntos}}
                            @elseif(!$puntos_comprados && $puntos_otorgados)
                                {{$puntos_otorgados->puntos}}
                            @else
                                0
                            @endif
                        @endif
                        <a href="{{route('point.create')}}" class="pull-right btn btn-sm btn-warning"  title='Buy points'>+</a>

                        </strong></h3> 
                    </div>
                    </li>
                    @if($user->model=='natural')

                    <li class="media event " style='color: white;'>
                    <a class="pull-left  profile_thumb" style='color: white;'>
                        <i class="fa fa-user "></i>
                    </a>
                    <div class="media-body" >
                        <a class="title" href="#" style='color: white;'>Bought points</a>
                        <h3><strong>
                        @if($puntos_comprados)
                            {{$puntos_comprados->puntos}}
                        @else
                            0
                        @endif    
                        </strong></h3> 
                    </div>
                    </li>
                    <li class="media event">
                    <a class="pull-left border-green profile_thumb">
                        <i class="fa fa-user green"></i>
                    </a>
                    <div class="media-body">
                        <a class="title" href="#">Points awarded </a>
                        <h3><strong>
                            @if($puntos_otorgados)
                                {{$puntos_otorgados->puntos}}
                            @else
                                0
                            @endif
                            @if(Auth::user()->model == 'juridico')
                            <a href="#" class="pull-right btn btn-sm btn-warning" data-toggle="modal" data-target="#asignarPuntos" title='Assign points'>+</a>
                            @endif
                        </strong></h3> 
                    </div>
                    </li>
                    @endif
                 
                    
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
@if(Auth::user()->model == 'juridico')
<div class="modal fade" id="asignarPuntos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form action="{{route('user.puntos', $user->id)}}" method="post">
        @csrf()
        @method('POST')
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign points <small>Points to be distributed: <span id='puntos'>{{$puntos_empresa->puntos}}<span></small> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <table class="table table-striped table-bordered bulk_action">
            <thead>
            <th>Points to assign</th>
            </thead>
            <tbody id='empleados'>
            <tr >
                <td>
                    <input type="number" name="puntos" id="" class="form-control">
                </td>
            </tr>
            </tbody>
        </table>
        </div>
        <div class="modal-footer">
        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Assign points </button>
        </div>
    </form>

    </div>
    </div>
</div>
@endif
@endsection
@section('footer')

@endsection
