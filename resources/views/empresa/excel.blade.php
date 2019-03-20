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
                El archivo excel deberá seguir este orden.
                <ul>
                    <li>Name: Debe ser el nombre completo, Ej: John Doe</li>
                    <li>Birthdate: Fecha formato "aaaa-mm-dd"</li>
                    <li>Phone: Numero telefonico </li>
                    <li>Nationality: Diminutivo del pais, Ej: VE - Venezuela</li>
                    <li>Address: direccion</li>
                    <li>email: Ej: johndoe@dominio.com</li>
                </ul>
                
            </div>
		</div>
        <div class="col-md-12">
            <label for="">Subir archivo excel</label>
            <input type="file" name="excel" class='form-control' id="excel">
        </div>
        
       
	</div>
</div>
@endsection