@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="view-boton">
				<a href="#" class="view-boton-i"><i class="fas fa-list-ul"></i></a>
				<a class="view-boton-i" href="#"><<i class="fas fa-table"></i></a>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card card-profile">
			    <img class="card-img-top img-fluid img-profile-list" src="{{url('/')}}/img/profile-list.png" alt="Card image"/>
			    <div class="card-body">
			      <h4 class="card-title">John Doe</h4>
			      <p class="card-text"><b>Cargo:</b> System Engineer </p>
			      <a href="#" class="btn btn-primary btn-profile-list">See Profile</a>
			    </div>
			  </div>
		</div>
		<div class="col-md-4">
			<div class="card card-profile">
			    <img class="card-img-top img-fluid img-profile-list" src="{{url('/')}}/img/profile-list.png" alt="Card image"/>
			    <div class="card-body">
			      <h4 class="card-title">John Doe</h4>
			      <p class="card-text"><b>Cargo:</b>  Accountant</p>
			      <a href="#" class="btn btn-primary btn-profile-list">See Profile</a>
			    </div>
			  </div>
		</div>
		<div class="col-md-4">
			<div class="card card-profile">
			    <img class="card-img-top img-fluid img-profile-list" src="{{url('/')}}/img/profile-list.png" alt="Card image"/>
			    <div class="card-body">
			      <h4 class="card-title">John Doe</h4>
			      <p class="card-text"><b>Cargo:</b> Manager Chief Executive</p>
			      <a href="#" class="btn btn-primary btn-profile-list">See Profile</a>
			    </div>
			  </div>
		</div>
		<div class="col-md-12">
			<ul class="pagination justify-content-center">
			    <li class="page-item"><a class="page-link" href="javascript:void(0);">Previous</a></li>
			    <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
			    <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
			    <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
			    <li class="page-item"><a class="page-link" href="javascript:void(0);">Next</a></li>
  </ul>
		</div>
	</div>
</div>
@endsection