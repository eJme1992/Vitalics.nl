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
    <div class="x_panel">
      <div class="x_content">
        <p class="text-muted font-13 m-b-30">
          Selecciona los trabajadores que quieres asignarles puntos
        </p>
        <table id="dt-empleados" class="table table-striped table-bordered bulk_action">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Telefono</th>
              <th>Cargo</th>
              <th style='cursor:pointer;'><input type="checkbox" id="check-all" class="flat"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($usuarios as $user)
                <tr>
                  <td id='nombre'>{{$user->name}}</td>
                  <td>{{$user->phone}}</td>
                  <td>{{$user->cargo}}</td>
                  <td id='{{$user->user_id}} ' class='id_user'><input type="checkbox" value='{{$user->user_id}}' name='id_user'  class="flat "></td>

                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-md-12">
        <button type='button' class="btn btn-success " data-toggle="modal" data-target="#asignarPuntos">Asignar puntos</a>
    </div>
      <!-- Modal -->
        <div class="modal fade" id="asignarPuntos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form action="{{route('save.puntos')}}" method="post">
              @csrf()
              @method('POST')
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Asignar puntos <small>Puntos a repartir: <span id='puntos'>{{$puntos->puntos}}<span></small> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table class="table table-striped table-bordered bulk_action">
                  <thead>
                    <th>Nombre</th>
                    <th>Puntos a asignar</th>
                  </thead>
                  <tbody id='empleados'>
                    <!-- <tr id='id'>
                      <td>
                        Nombre
                      </td>
                      <td>
                        <input type="hidden" name="id_user" value=''>
                        <input type="number" class='form-control' >
                      </td>
                    </tr> -->
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Asignar Puntos</button>
              </div>
            </form>

            </div>
          </div>
        </div>

	</div>
</div>
@endsection
@section('footer')
  <script>
    $(document).ready(function(){
      $('#dt-empleados').DataTable(
      //   {
      //   "serverSide":true,
      //   "ajax": "{{route('api.listado', Auth::user()->id)}}",
      //   "columns": [
      //     {data: 'user_id'},
      //     {data: 'name'},
      //     {data: 'phone'},
      //     {data: 'cargo'},
      //   ]
      // }
      )
    });
  </script>
  <script>
    $(".id_user").click(function() {
      $(this ).children().toggleClass('checked');
      var id = $(this).prop('id');
      var valores = "";

      if(!$(this).children().hasClass('checked')){
       
        $("#empleados > #"+id).remove(); //ME FALTA ELIMINAR CUANDO SE DESELECCIONE EL EMPLEADO

      }else{
         // Obtenemos todos los valores contenidos en los <td> de la fila
        // seleccionada
        $(this).parents("tr").find("#nombre").each(function() {


          valores += $(this).html() + "\n";
          //creamos los campos en el  modal
          // var trs=$("#tabla tr").length;
          var nuevaFila="<tr id='"+id+"'>";
          // añadimos las columnas
          nuevaFila+="<td>"+valores+"</td>";
          nuevaFila+="<td><input type='hidden' name='id_user' value='"+id+"'><input type='number' class='form-control puntos' ></td>";
          nuevaFila+="</tr>";
          $("#empleados").append(nuevaFila);
          var  puntos = calcular_puntos();

          $("#empleados tr td .puntos").prop('value', puntos);
        });
        
      }

      function calcular_puntos(){
        //Repartir puntos equitativamente
        var trs=$("#empleados tr").length;
        var pts = $("#puntos").text();
        var resultado = pts / trs;
        return resultado;
      }
     
      // console.log(valores);
      //   alert(valores+", "+ id);
      // });
  </script>
  
@endsection