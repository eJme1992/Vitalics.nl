@extends('layouts.app')
@section('content')
<div class="container"  style=' padding:10px;'>
    <div class="row " style='background-color: #424E5C;'>
        <div class="col-md-3" >
            <img src="{{url('/')}}/img/profile.png" class="img-prueba"  id="img-prueba">
        </div>
        <div class="col-md-9 " style='border-left:#B6BEC9 2px solid;'>
            <div class="container" style='color:white; padding-left:10px;'>
                <div class="row">
                    <center>
                        <h3 >Joe Doe</h3><br>
                    </center>
                </div>
                <div class="row" style='font-size:17px; '>
                    <div class="col-md-6">
                        D.N.I.: 22222222<br>
                        Edad: 32 años<br>
                        Cargo: Gerente<br>
                    </div>
                    <div class="col-md-6">
                        Phone: 22222222<br>
                        Email: email@email.com<br>
                        Nationality: De su pais<br>
                    </div>
                </div>
                <div class="row " style='font-size:17px;'>
                    <div class='col-md-12'>Direccion: Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam, quam.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" >
        <div class="col-md-8">
            <center>
                <h3 class='mg-b' style='padding-top:10px;'>SERVICIOS INSCRITOS</h3>
            </center>
            <div class="x_panel">
                
                <div class="x_content">
                <article class="media event">
                    <a class="pull-left date">
                    <p class="month">April</p>
                    <p class="day">23</p>
                    </a>
                    <div class="media-body">
                    <a class="title" href="#">Item One Title</a>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      <p>Facebook Campaign</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 100%;">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="80" aria-valuenow="78" style="width: 80%;"></div>
                        </div>
                      </div>
                    </div>
                </article>
                <article class="media event">
                <a class="pull-left date">
                    <p class="month">April</p>
                    <p class="day">23</p>
                    </a>
                    <div class="media-body">
                    <a class="title" href="#">Item One Title</a>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      <p>Facebook Campaign</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 100%;">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="30" aria-valuenow="78" style="width: 80%;"></div>
                        </div>
                      </div>
                    </div>
                </article>
                <article class="media event">
                <a class="pull-left date">
                    <p class="month">April</p>
                    <p class="day">23</p>
                    </a>
                    <div class="media-body">
                    <a class="title" href="#">Item One Title</a>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      <p>Facebook Campaign</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 100%;">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50" aria-valuenow="78" style="width: 80%;"></div>
                        </div>
                      </div>
                    </div>
                </article>
                <article class="media event">
                <a class="pull-left date">
                    <p class="month">April</p>
                    <p class="day">23</p>
                    </a>
                    <div class="media-body">
                    <a class="title" href="#">Item One Title</a>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      <p>Facebook Campaign</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 100%;">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="100" aria-valuenow="78" style="width: 80%;"></div>
                        </div>
                      </div>
                    </div>
                </article>
                <article class="media event">
                <a class="pull-left date">
                    <p class="month">April</p>
                    <p class="day">23</p>
                    </a>
                    <div class="media-body">
                    <a class="title" href="#">Item One Title</a>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      <p>Facebook Campaign</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 100%;">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="100" aria-valuenow="78" style="width: 80%;"></div>
                        </div>
                      </div>
                    </div>
                </article>
                </div>
            </div>
        </div>
        <div class="col-md-4" style='background-color:#F4A958; height:100%;'>
            <center>
                <h3 class='mg-b' style='padding-top:10px;'>PUNTOS</h3>
            </center>

            <div>
                
                <ul class="list-unstyled top_profiles scroll-view">
                    <li class="media event">
                    <a class="pull-left border-aero profile_thumb">
                        <i class="fa fa-user aero"></i>
                    </a>
                    <div class="media-body">
                        <a class="title" href="#">Puntos Otorgados </a>
                        <h3><strong>200 </strong></h3> 
                    </div>
                    </li>
                    <li class="media event">
                    <a class="pull-left border-green profile_thumb">
                        <i class="fa fa-user green"></i>
                    </a>
                    <div class="media-body">
                        <a class="title" href="#">Puntos Comprados</a>
                        <h3><strong>30 </strong></h3> 
                    </div>
                    </li>
                    <li class="media event">
                        <a class="pull-left border-blue profile_thumb">
                            <i class="fa fa-user blue"></i>
                        </a>
                    <div class="media-body">
                         <a class="title" href="#">Puntos Totales </a>
                        <h3><strong>230 </strong></h3> 
                    </div>
                    </li>
                    
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')

@endsection
