@extends('layouts.app')
@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-7 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>New Employee</h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <form id="crear_usuario" class="form-horizontal form-label-left input_mask">
                        @csrf @method('POST')
                        <div class="col-md-12 col-xs-12 col-sm-12 mg-b">
                            <center>
                                <img src="{{url('/')}}/img/profile.png" class="img-prueba" id="img-prueba">
                                <div id="preview"></div>
                                <button type="button" id="change-photo" class="btn btn-profile">Profile photo</button>
                                <input type="file" class="form-control hide" name="profile" id="photo" />
                                <center>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                            <input type="text" name='name' class="form-control has-feedback-left" id="inputSuccess2" placeholder="Name" required>
                            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                            <input type="text" class="form-control" name='email' id="inputSuccess3" placeholder="Email" required='required'>
                            <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        <!-- 
               <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                  <input type="text"  data-inputmask="'mask': '9999-99-99'" class="form-control has-feedback-left" id="inputSuccess4" name='birthdate' placeholder="Birthdate" required>
                  <span class="fa fa-birthday-cake form-control-feedback left" aria-hidden="true"></span>
               </div> -->

                        <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                            <input type="text" name='cargo' class="form-control has-feedback-left" id="inputSuccess2" placeholder="Charge" required>
                            <span class="fa fa-briefcase form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                            <input type="text" maxlength='9' class="form-control" id="inputSuccess5" name='phone' placeholder="Phone" required>
                            <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                            <select name="nationality" class="form-control has-feedback-left" required>
                     @include('layouts.paises')
                  </select>
                            <span class="fa fa-globe form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                            <textarea name="address" id="inputSuccess3" class='form-control has-feedback-left' placeholder='Address' required></textarea>
                            <span class="fa fa-map-marker form-control-feedback left" aria-hidden="true"></span>
                        </div>


                        <div class="form-group">
                            <div class="col-xs-12 " id="botoncrear_usuario">
                                <a name="enviarcrear_usuario" id="enviarcrear_usuario" class="btn-dark btn-block btn" href="javascript:crear(1)">
                    Submit <i class="fas fa-check"></i></a>
                            </div>
                        </div>

                    </form>
                </div>



            </div>


        </div>
        <div class="col-md-5">
            <div class="alert alert-info fade in" role="alert">
                Please fill Out the form to register a new employee.
            </div>

            <div id="resultadocrear_usuario"></div>

            @include('usuarios.partials.error') @if(Session::has('message'))
            <div class="alert alert-info alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button> @if(Session::has('user')) El usuario <strong>{{Session::get('user')}}
              <strong> ya está registrado en nuestro sistema, ¿Desea enviarle una invitación? <br>
            <form action="{{route('notificacion.store')}}" method='POST'>
               @csrf
               @method('POST')
               <input type="hidden" name='user' value="{{Session::get('user')}}">
               <button type='submit' class='btn btn-success'>Si</button>
            </form>
            @else
               {{Session::get('message')}}
            @endif

         </div>
      @endif
   </div>
</div>
</strong></div>

@endsection
@section('footer')
<script type="text/javascript">
   var photo = document.getElementById("photo");
   var boton = document.getElementById("change-photo").addEventListener("click", () =>{ photo.click()});
    var photoT = document.getElementById("img-prueba");
    
     photo.onchange = function(e) {
     // Creamos el objeto de la clase FileReader
     let reader = new FileReader();
   
     // Leemos el archivo subido y se lo pasamos a nuestro fileReader
     reader.readAsDataURL(e.target.files[0]);
     
     // Le decimos que cuando este listo ejecute el código interno
     reader.onload = function(){
       let preview = document.getElementById('preview');
         image = document.createElement("img");
   
       image.src = reader.result;
       image.classList.add("img-p", "img-circle");
       photoT.style.display ="none";  
       preview.appendChild(image);
     };
   }   
   
   
</script>

  <script type="text/javascript">
    function crear(op){
    if(op===1){  
             PFCrear('{{route('usuarios.nuevo')}}','crear_usuario',op);
          }     
    };
    
        function PFCrear(url,formulario,op){var formData=new FormData(jQuery('#'+formulario)[0]);var html='<a name="enviar'+formulario+'" id="enviar'+formulario+'" class="btn-dark btn-block btn" href="javascript:crear('+op+')" >Submit <i class="fas fa-check"></i></a>';$.ajax({url:url,type:'POST',contentType:false,processData:false,dataType:'json',data:formData,beforeSend:function(){$("#resultado"+formulario).html('<div class="alert alert-success">Procesando...!</div>');$("#boton"+formulario).html('<button disabled=""  type="button" name="enviar'+formulario+'" id="enviar'+formulario+'" class="btn-dark btn-block btn">Submit <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i></button> ');}}).done(function(data,textStatus,jqXHR){var getData=jqXHR.responseJSON;if(data.status=='ok'){document.getElementById(formulario).reset();$("#resultado"+formulario).html('<div class="alert alert-success">'+data.mensaje+' | <a href="javascript:location.reload();">Refresh</a></div>');$("#boton"+formulario).html(html);}else{$("#resultado"+formulario).html('<div class="alert alert-danger"><strong>ERROR! </strong>'+data.mensaje+'</div>');$("#boton"+formulario).html(html);}}).fail(function(data,textStatus,errorThrown){var errorsHtml='';var errors=data.responseJSON;$.each(errors,function(key,value){if(key!='message'){$.each(value,function(key1,value1){errorsHtml+=value1;});}});$("#resultado"+formulario).html('<div class="alert alert-danger"><strong>ERROR! </strong>'+errorsHtml+'</div>');$("#boton"+formulario).html(html);})};
</script>

@endsection
