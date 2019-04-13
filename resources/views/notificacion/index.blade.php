@extends('layouts.app') @section('content')
<div class="container">
    <!-- <div class="row"> -->
    <div class="row">
        <div class="col-md-12">
            <div class="view-boton float-right">
                <a href="#" class="view-boton-i" data-toggle="tooltip" title="View like details"><i class="fa fa-list-ul fa-lg"></i></a>
                <a class="view-boton-i" href="#" data-toggle="tooltip" title="View like icons"><i class="fa fa-table fa-lg"></i></a>
            </div>
        </div>

    </div>
    <hr>
    <div class="container">
    <div class="row">
        
        <div class="col-md-12">
        @include('usuarios.partials.message')
        </div>
    </div>
    <div class="x_panel">
      <div class="x_content">
      @if(countNotiCualquiera(Auth::user()->id) > 0)
        
        <table  class="table table-striped table-bordered bulk_action">
          <thead>
            <tr>
              <th>Alerts</th>
            </tr>
          </thead>
          <tbody>
            @foreach($notificaciones as $notificacion)
                <tr>
                  <td >{{$notificacion->mensaje}}</td>
                  <td ><a href="{{url($notificacion->url)}}"   class="btn btn-info ">View</a></td>

                </tr>
            @endforeach
          </tbody>
        </table>
        @else
            Does not have notifications
        @endif
      </div>
    </div>
    </div>
    </div>
    <div class="col-md-12">
        <ul class="pagination justify-content-center">
            {{$notificaciones->render()}}
            <!-- <li class="page-item"><a class="page-link" href="javascript:void(0);">Previous</a></li>
			    <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
			    <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
			    <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
			    <li class="page-item"><a class="page-link" href="javascript:void(0);">Next</a></li> -->
        </ul>
    </div>
    <!-- </div> -->
</div>
@endsection