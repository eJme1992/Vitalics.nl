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
            @include('usuarios.partials.message')
        </div>
        <div class="col-md-12">
            <div class="alert alert-info alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                In this section you can import an excel file with the list of workers.<br>
                It should be called specifically "Employees.xlsx".<br>
                The excel file should follow this order:

                <ul>
                    <li>name: Must be the full name, Example: John Doe</li>
                    <li>birthdate: Date format "yyyy-mm-dd"</li>
                    <li>phone: Phone number </li>
                    <li>nationality: Abbreviation of the country, Example: VE - Venezuela</li>
                    <li>address: Exact direction</li>
                    <li>email: Example: johndoe@dominio.com</li>
                    <li>charge: Example: johndoe@dominio.com</li>
                </ul>
                
            </div>
		</div>
        <div class="col-md-12">
            <form action="{{route('excel.import')}}" method='POST'  enctype="multipart/form-data" >
                @method('POST')
                @csrf
                <div class="col-md-8">
                    <label for="">Upload excel file</label>
                    <input type="file" name="excel" class='form-control' id="excel">
                </div>
                <div class="col-md-4">
                    <br>
                    <button type="submit" class='btn btn-primary'>Upload</button>
                </div>
            </form>
        </div>
        
       
	</div>
</div>
@endsection