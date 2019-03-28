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
        <div class="x_panel">
          <div class="x_content">
            <p class="text-muted font-13 m-b-30">
              Selecciona los trabajadores que quieres asignarles puntos
            </p>
            <table id="dt-empleados" class="table table-striped table-bordered bulk_action">
              <thead>
                <tr>
                  <th><input type="checkbox" id="check-all" class="flat"></th>
                  <th>Nombre</th>
                  <th>Telefono</th>
                  <th>Cargo</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
          </div>
        </div>
	</div>
</div>
@endsection
@section('footer')
  <script>
    $(document).ready(function(){
      $('#dt-empleados').DataTable({
        "serverSide":true,
        "ajax": "{{route('api.listado', Auth::user()->id)}}",
        "columns": [
          {data: 'user_id'},
          {data: 'name'},
          {data: 'phone'},
          {data: 'cargo'},
        ]
      })
    });
  </script>
@endsection