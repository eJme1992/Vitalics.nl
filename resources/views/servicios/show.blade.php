@extends('layouts.app') @section('content')
<style type="text/css">
  #regiration_form fieldset:not(:first-of-type) {
    display: none;
  }
  </style>
<div class="container">
    <!-- <div class="row"> -->
    <div class="row">
        <div class='col-md-8' style="padding-top:15.5px">
            <form action="{{route('servicios.filtro')}}" method="post">
                @csrf @method('POST')
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <h2 class="text-center">{{$servicio->nombre}}</h2>
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
        <div class="col-md-4" style='margin-top: 20px;'>
            <div class="card card-profile">
                <img class="card-img-top img-fluid img-profile-list" src="{{url($servicio->imagen)}}" alt="Card image" />
                <div class="card-body">
                    <h4 class="card-title">{{$servicio->nombre}}</h4>
                    <p class="card-text"> {{$servicio->descripcion}}</p>
                    <p class="card-text txt-cost"><b>{{$servicio->costo}}.Points</b></p>

                   {{--  <a href="{{route('servicios.show', $servicio->id)}}" class="btn btn-success btn-profile-list">Compartir Servicios con otros miembros</a>  --}}
                    <center><a  href="#">Compartir Servicios Con Otros Miembros</a></center>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <table class="table">
              <thead class="thead-dark">
                 <span class="pull-right"><button class="btn btn-primary btn-md" data-toggle="modal" data-target="#newSections">New Sections</button></span>
                <tr>
                  <th scope="col">Section</th>
                  <th scope="col">Type</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($servicio->sections as $s)
                  <tr>
                      <td>{{$s->descripcion}}</td>
                      <td>{{$s->lugar}}</td>
                      <td>
                          <a href="#" class="btn btn-md btn-success" data-toggle="modal" data-target="#myModal{{$s->id}}">Details</a>
                          <a href="#" class="btn btn-md btn-success">Share</a>
                      </td>
                  </tr>




                  <!-- Modal detalles de sections -->
                    <div class="modal fade" id="myModal{{$s->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{$s->descripcion}}</h4>
                          </div>
                          <div class="modal-body">
                            ...
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                          </div>
                        </div>
                      </div>
                    </div>
                @endforeach
              </tbody>
            </table>
        </div>
    </div>
    <!-- </div> -->
</div>


 <!-- Modal crear sections-->
<div class="modal fade" id="newSections" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Sections for {{Auth::user()->name}}</h4>
      </div>
      <div class="modal-body">
         <div class="progress">
            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        <form id="regiration_form" novalidate  method="post">
              <fieldset>
                <h2>Step 1: Create Services</h2>
                <div class="form-group">
                    <label for="email">Services</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Service">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Place</label>
                    <input type="password" class="form-control" id="password" placeholder="Place">
                </div>
                <input type="button" name="password" class="next btn btn-info" value="Next" />
              </fieldset>
              <fieldset>
                <h2> Step 2: Select Personal</h2>
                 <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Check</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($usuarios as $u)
                        <tr>
                            <td>{{$u->name}}</td>
                            <td>{{$u->phone}}</td>
                            <td>{{$u->email}}</td>
                            <td>
                                <input type="checkbox" name="">
                            </td>
                        </tr>
                        @empty
                         <h3 class="text center text-danger">you do not have workers</h2>
                      @endforelse
                    </tbody>
                  </table>
               <input type="button" name="previous" class="previous btn btn-default" value="Previous" />
                <input type="submit"  class="submit btn btn-success" value="Submit" />
              </fieldset>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


@endsection
@section('footer')
<script type="text/javascript">
    $(document).ready(function(){
      var current = 1,current_step,next_step,steps;
      steps = $("fieldset").length;
      $(".next").click(function(){
        current_step = $(this).parent();
        next_step = $(this).parent().next();
        next_step.show();
        current_step.hide();
        setProgressBar(++current);
      });
      $(".previous").click(function(){
        current_step = $(this).parent();
        next_step = $(this).parent().prev();
        next_step.show();
        current_step.hide();
        setProgressBar(--current);
      });
      setProgressBar(current);
      // Change progress bar action
      function setProgressBar(curStep){
        var percent = parseFloat(100 / steps) * curStep;
        percent = percent.toFixed();
        $(".progress-bar")
          .css("width",percent+"%")
          .html(percent+"%");
      }

     // Handle form submit and validation
    $( "#regiration_form" ).submit(function(event) {
    var error_message = '';
    if(!$("#email").val()) {
    error_message+="Please Fill Email Address";
    }
    if(!$("#password").val()) {
    error_message+="<br>Please Fill Password";
    }
    if(!$("#mobile").val()) {
    error_message+="<br>Please Fill Mobile Number";
    }
    // Display error if any else submit form
    if(error_message) {
    $('.alert-success').removeClass('hide').html(error_message);
    return false;
    } else {
    return true;
    }
    });
});// fin document ready
</script>
@endsection
