@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row">
        <div class='col-md-8' style="padding-top:15.5px">
            <form action="{{route('servicios.filtro')}}" method="post">
                @csrf @method('POST')
                <div class="container">

                    <div class="row">
                        <div class="btn-group " style='float:left; '>
                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false"><span class='fa fa-filter'></span><span class="caret"></span>
						</button>
                            <ul role="menu" class="dropdown-menu " style='width: 500px; overflow:hidden;'>
                                <div class="row panel-body" style='margin-top:10px; '>
                                    <div class="col-md-9 grid_slider">
                                        <p>Filter</p>
                                    </div>
                                    <div class="col-md-2">
                                        <p>Activate</p>
                                    </div>
                                </div>
                                <div class="row" style='padding:5px;'>
                                    <div class="col-md-9 grid_slider">
                                        <input type="hidden" id="range" value="" name="price" class="irs-hidden-input" readonly="">
                                    </div>
                                    <div class="col-md-2">
                                        <div class="checkbox">
                                            <label class="">
										<div class="icheckbox_flat-green checked" style="position: relative;">
											<input type="checkbox" class="flat" name="filtros[price]" value='true' style="position: absolute; opacity: 0;">
											<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
										</div> 
										</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style='padding:10px; border-top: solid 2px #D7DCDE;'>
                                    <div class="col-md-9">
                                        <div class="controls">
                                            <div class="input-prepend input-group">
                                                <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                                <input type="text" style="width: 200px" name="fecha" id="reservation" class="form-control" value="01/01/2019 - 01/25/2020">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="checkbox">
                                            <label class="">
										<div class="icheckbox_flat-green checked" style="position: relative;">
											<input type="checkbox" class="flat" name='filtros[fecha]' value='true' style="position: absolute; opacity: 0;">
											<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
										</div> 
										</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style='padding:10px; border-top: solid 2px #D7DCDE;'>
                                    <div class="col-md-9">
                                        <select class="select2_single form-control" name='tipo' tabindex="-1">
									<option>tipo 1</option>
									<option>tipo 2</option>
									<option>tipo 3</option>
									<option>tipo 4</option>
									<option>tipo 5</option>
									<option>tipo 6</option>
								</select>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="checkbox">
                                            <label class="">
										<div class="icheckbox_flat-green checked" style="position: relative;">
											<input type="checkbox" class="flat" name='filtros[tipo]' value='true' style="position: absolute; opacity: 0;">
											<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
										</div> 
										</label>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </div>
                        <div class="col-md-3 ">
                            <input type="text" name="buscar" class='form-control' placeholder='Search for services'>
                        </div>
                       
                        <div class="col-md-2 ">
                            <button type="submit" class='btn btn-success'>Search <i class="fas fa-search"></i></button>
                        </div>


                    </div>
                </div>

            </form>
        </div>
        <div class="col-md-4">
            <div class="row">
            <div class="col-md-12">
                <div class="view-boton float-right">
                    <a href="#" class="view-boton-i" data-toggle="tooltip" title="View like details"><i class="fa fa-list-ul fa-lg"></i></a>
                    <a class="view-boton-i" href="#" data-toggle="tooltip" title="View like icons"><i class="fa fa-table fa-lg"></i></a>
                </div>
            </div>
        </div>
        </div>

    </div>
    <hr>
    <div class="row">
        @foreach($servicios as $servicio)
        <div class="col-md-4" style='margin-top: 20px;'>
            <div class="card card-profile">
                <img class="card-img-top img-fluid img-profile-list" src="{{url('/')}}{{$servicio->imagen}}" alt="Card image" />
                <div class="card-body">
                    <h4 class="card-title">{{$servicio->nombre}}</h4>
                    <p class="card-text"> {{$servicio->descripcion}}</p>
                    <p class="card-text txt-cost"><b>{{$servicio->costo}} Points</b></p>

                    <a href="{{route('servicios.show', $servicio->id)}}" class="btn btn-primary btn-profile-list">Learn More</a>
                </div>
            </div>
        </div>


        @endforeach
    </div>
    <div class="col-md-12">
        <ul class="pagination justify-content-center">
            {{$servicios->render()}}
          
        </ul>
    </div>
    <!-- </div> -->
</div>
@endsection