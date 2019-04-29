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
          Select the employees you want to assign points.
        </p>
        <table id="dt-empleados" class="table table-striped table-bordered bulk_action">
          <thead>
            <tr>
              <th>Name</th>
              <th>Phone</th>
              <th>Position</th>
              <th style='cursor:pointer;'><input type="checkbox" id="check-all" class="flat"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($usuarios as $user)
                <tr>
                  <td id='nombre'>{{$user->name}}</td>
                  <td>{{$user->phone}}</td>
                  <td>{{$user->cargo}}</td>
                  <td id='{{$user->user_id}}' class='id_user'><input type="checkbox"  name='id_user'  class="flat "></td>

                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-md-12">
        <button type='button' class="btn btn-success " data-toggle="modal" data-target="#asignarPuntos">Assign points</a>
    </div>
      <!-- Modal -->
        <div class="modal fade" id="asignarPuntos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form action="{{route('save.puntos')}}" method="post">
              @csrf()
              @method('POST')
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assign points <small>Points to be distributed: <span id='puntos'>{{$puntos->puntos}}<span></small> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table class="table table-striped table-bordered bulk_action">
                  <thead>
                    <th>Name</th>
                    <th>Points to assign</th>
                  </thead>
                  <tbody id='empleados'>
                    <!-- Se cargan los empleados -->
                    
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

	</div>
</div>
@endsection
@section('footer')
  <script>
    $(document).ready(function(){
      $('#dt-empleados').DataTable()
    });
  </script>
  <script>
    $(".id_user").click(function() {
      $(this ).children().toggleClass('checked');
      var id = $(this).prop('id');
      var valores = "";

      if($(this).children().hasClass('checked')){
       
        // Obtenemos todos los valores contenidos en los <td> de la fila
        // seleccionada
        $(this).parents("tr").find("#nombre").each(function() {

          valores += $(this).html() + "\n";
          //creamos los campos en el  modal
          var nuevaFila="<tr id='"+id+"'>";
          // añadimos las columnas
          nuevaFila+="<td>"+valores+"</td>";
          nuevaFila+="<td><input type='hidden' name='id_user[]' value='"+id+"'><input type='number' name='puntos[]' class='form-control puntos' ></td>";
          // nuevaFila+="<td><button type='button' id='"+id+"' class='boton_eliminar btn btn-sm btn-danger'>x</button></td>";

          nuevaFila+="</tr>";

          $("#empleados").append(nuevaFila);
          var  puntos = calcular_puntos();

          $("#empleados tr td .puntos").prop('value', puntos);
        });
        
      }
      
    });
      
    //quitar empleados seleccionados

    $('.boton_eliminar').click(function(){

      var idx =  $(this).prop('id');
      $(this).closest('tr').remove(); //removemos el empleado

      var  puntos = calcular_puntos(); //calculamos de nuevo los puntos

      $("#empleados tr td .puntos").prop('value', puntos); //actualizamos puntos

    });

    

    function calcular_puntos(){
        //Repartir puntos equitativamente
        var trs=$("#empleados tr").length;
        var pts = $("#puntos").text();
        var resultado = pts / trs;
        return  parseInt(resultado);
      }
  </script>
  
@endsection