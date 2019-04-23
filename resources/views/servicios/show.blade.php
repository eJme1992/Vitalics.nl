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
                @if(Auth::user()->model == 'juridico')
                    <span class="pull-right"><button class="btn btn-primary btn-md" data-toggle="modal" data-target="#newSections">New Sections</button></span>
                 @endif
                <tr>
                  <th scope="col">Section</th>
                  <th scope="col">Type</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach(Auth::user()->company->empresa->sections as $s)
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
                            <h4 class="modal-title" id="myModalLabel">Sections <strong>{{$s->descripcion}}</strong></h4>
                          </div>
                          <div class="modal-body">
                            <h2>Service</h2>
                            <p><strong>Service Name: </strong>{{$s->service->name}}</p>
                            <p><strong>Service Kind: </strong>{{$s->service->tipo}}</p>
                            <p><strong>SErvice Sessions: </strong>{{$s->service->sesiones}}</p>
                            <p><strong>Service Cost: </strong>{{$s->service->costo}}</p>
                            <p><strong>Service Description: </strong>{{$s->service->descripcion?$s->service->descripcion:'Not Description'}}</p>
                            <p><strong>Service Status: </strong>{{$s->service->estado}}</p>
                            <h2>Section</h2>
                            <p><strong>Section Kind: </strong>{{$s->lugar}}</p>
                            <p><strong>Section Places: </strong>{{$s->cupos}}</p>
                             <p><strong>Section Sttatus: </strong>{{$s->estado}}</p>
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
            <input type="hidden" name="empresa_id" value="{{Auth::user()->id}}">
            <input type="hidden" name="servicio_id" value="{{$servicio->id}}">
            <input type="hidden" name="totalPoints" id="valueTotalPoints">
            <input type="hidden" name="estado" value="activo">
              <fieldset>
                <h2>Step 1: Create Services</h2>
                <div class="alert alert-danger hide" role="alert">
                  
                </div>
                 <div id="hide" class="col-md-12 row">
                    <div class="col-md-4 mg-b">
                        <label>Kind:</label>
                        <input type="text" name="lugar" id="lugar" class="form-control" value="Company" readonly="">
                    </div>
                    <div class="col-md-4 mg-b">
                        <label>Cupos:</label>
                        <input required="" type="number" class="form-control mg-b" name="cupos" id="cupos" placeholder="0" />
                    </div>
                    <div class="col-md-12 mg-b">
                        <label>Description</label>
                        <textarea required="" name="descripcion" id="descripcion" class="form-control"></textarea>
                    </div>
                    <div class="col-lg-12" style="margin-top:5px">
                        <div id="resultadonew_servicio"></div>
                    </div>
                </div>
                <input type="button" name="password" class="next btn btn-info" value="Next" />
              </fieldset>
              <fieldset>
                
                <h2> Step 2: Select Personal</h2>
                <div class="alert alert-danger hide" role="alert" id="message_points">
                  
                </div>
                 <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Points</th>
                        <th scope="col">Check</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($usuarios as $u)
                        <tr>
                            <td>{{$u->name}} </td>
                            <td>{{$u->phone}}</td>
                            <td>{{$u->email}}</td>
                            <td>{{$u->points->puntos}} Points.</td>
                            <td>
                                <input type="checkbox" name="user[]"  class="form-control check_points" value="{{$u->id}}" data-points={{$u->points->puntos}}>
                            </td>
                        </tr>
                        @empty
                         <h3 class="text center text-danger">you do not have workers</h2>
                      @endforelse
                      <tr>
                          <td colspan="3"><h3> Total</h3></td>
                          <td><h3 id="points_print">0 Points.</h3></td>
                      </tr>
                    </tbody>
                  </table>
               <input type="button" name="previous" class="previous btn btn-default" value="Previous" />
                
                <a class="btn btn-success submit" id="subm">Submit</a>
              </fieldset>

        </form>
      </div>
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> --}}
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
     $( "#subm" ).click(function(event) {

      
        var error_message = '';
        if(!$("#cupos").val()) {
            $("#cupos").css('border', '1px solid red');
        error_message+="<br>Please Fill Places";
        }
        if(!$("#lugar").val()) {
            $("#lugar").css('border', '1px solid red');
        error_message+="<br>Please Fill Location";
        }
        if(!$("#descripcion").val()) {
            $("#descripcion").css('border', '1px solid red');
        error_message+="<br>Please Fill Description";
        }
        if ($('input:checkbox:checked').length > $("#cupos").val() ) { //validar el maximod e cupos
          //alert("fsfsfs");
         $('#message_points').removeClass('hide').html("Members exceed the quota limit");
         return false;
      }
        // Display error if any else submit form
        if(error_message) {
        $('.alert-danger').removeClass('hide').html(error_message);
        $(".previous").click();
        return false;
        } else {
     
        event.preventDefault();
         var formData = new FormData($("#regiration_form")[0]);
        $.ajax({
             headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
             },
            url: '{{route("seccioness.store")}}',
            type: 'POST',
            dataType: 'JSON',
            data: formData,
            contentType: false,
            cache: false,
            processData:false,
        })
        .done(function(data) {
            $('#newSections').modal('hide');
            alert(data.msg);

            location.reload();
        })
        .fail(function(error) {
          $('#message_points').removeClass('hide').html(error.responseJSON.msg);
        })
        .always(function() {
            console.log("complete");
        });
        
 
    }
    });
 
  //checked total en realtime 
     $(":checkbox").change(function() {

      var totalService = {{$servicio->costo}};

    var totalPoint = 0;
    $(":checkbox:checked").each(function() {
        totalPoint += +$(this).length * totalService;

    });
    $("#points_print").text(totalPoint+' Points.')
    $("#valueTotalPoints").val(totalPoint)

     //$('input:checkbox:not(":checked")').length;
})

    // $(".check_points").click( function(){
    //     var points = $(this).data('points');
    //    if( $(this).is(':checked') ){
    //     console.log(points++);
    //     $("#points_print").text(points++)
    //    }else{
    //     $("#points_print").text(points--)
    //    } 
    // });
});// fin document ready
</script>
@endsection
