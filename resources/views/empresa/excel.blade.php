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
            <div class="alert alert-info alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                En esta sección podras importar un archivo excel con la lista de trabajadores.<br>
                Debe llamarse especificamente "Empleados.xls"
                El archivo excel deberá seguir este orden.

                <ul>
                    <li>name: Debe ser el nombre completo, Ej: John Doe</li>
                    <li>birthdate: Fecha formato "aaaa-mm-dd"</li>
                    <li>phone: Numero telefonico </li>
                    <li>nationality: Diminutivo del pais, Ej: VE - Venezuela</li>
                    <li>address: direccion</li>
                    <li>email: Ej: johndoe@dominio.com</li>
                </ul>
                
            </div>
		</div>
        <div class="col-md-12">
            <form action="{{route('excel.import')}}" method='POST'  enctype="multipart/form-data" >
                @method('POST')
                @csrf
                <div class="col-md-8">
                    <label for="">Subir archivo excel</label>
                    <input type="file" name="excel" class='form-control' id="excel">
                </div>
                <div class="col-md-4">
                    <br>
                    <button type="submit" class='btn btn-primary'>Subir archivo</button>
                </div>
            </form>
        </div>
        
       
	</div>
</div>
@endsection