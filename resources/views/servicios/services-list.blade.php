@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="view-boton float-right">
				<a href="#" class="view-boton-i" data-toggle="tooltip" title="View like details" ><i class="fas fa-list-ul fa-lg"></i></a>
				<a class="view-boton-i" href="#" data-toggle="tooltip" title="View like icons"><i class="fas fa-table fa-lg"></i></a>
			</div>
		</div>
		@foreach($servicios as $servicio)
		<div class="col-md-4">
			<div class="card card-profile">
			    <img class="card-img-top img-fluid img-profile-list" src="{{url('/')}}/img/services.jpg" alt="Card image"/>
			    <div class="card-body">
			      <h4 class="card-title">{{$servicio->nombre}}</h4>
			      <p class="card-text"> {{$servicio->descripcion}}</p>
			      <p class="card-text txt-cost"><b>{{$servicio->costo}}$</b></p>
			      <a href="{{route('servicios.show', $servicio->id)}}" class="btn btn-primary btn-profile-list">Learn More</a>
			    </div>
			  </div>
		</div>
		@endforeach
		
		<div class="col-md-12">
			<ul class="pagination justify-content-center">
					{{$servicios->render()}}
			    <!-- <li class="page-item"><a class="page-link" href="javascript:void(0);">Previous</a></li>
			    <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
			    <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
			    <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
			    <li class="page-item"><a class="page-link" href="javascript:void(0);">Next</a></li> -->
  		</ul>
		</div>
	</div>
</div>
@endsection