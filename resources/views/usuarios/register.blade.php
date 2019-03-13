@extends('layouts.app')
@section('content')
<div class="container">
  
   <div class="row">
    <div class="col-md-7 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
            <h2>Nuevo empleado</h2>
            
            <div class="clearfix"></div>
            </div>
            <div class="x_content">
            
            <form action="{{route('usuarios.nuevo')}}" enctype="multipart/form-data" method='POST' class="form-horizontal form-label-left input_mask">
               @csrf
                @method('POST')
            <div class="col-md-12 col-xs-12 col-sm-12 mg-b">
               <center>   
                <img src="{{url('/')}}/img/profile.png" class="img-prueba"  id="img-prueba">
                <div  id="preview"></div>
                <button  type="button" id="change-photo" class="btn btn-profile">Profile photo</button>
                <input type="file" class="form-control hide" name="profile" id="photo"  />
                <center>
            </div>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                  <input type="text"   name='name' class="form-control has-feedback-left" id="inputSuccess2" placeholder="Name" required>
                  <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
               </div>

               <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                  <input type="text" class="form-control"  name='email' id="inputSuccess3" placeholder="Email" required='required' >
                  <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
               </div>
<!-- 
               <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                  <input type="text"  data-inputmask="'mask': '9999-99-99'" class="form-control has-feedback-left" id="inputSuccess4" name='birthdate' placeholder="Birthdate" required>
                  <span class="fa fa-birthday-cake form-control-feedback left" aria-hidden="true"></span>
               </div> -->

               <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                  <input type="text"  name='cargo' class="form-control has-feedback-left" id="inputSuccess2" placeholder="Cargo" required>
                  <span class="fa fa-briefcase form-control-feedback left" aria-hidden="true"></span>
               </div>

               <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                  <input type="text" class="form-control" id="inputSuccess5" name='phone'  placeholder="Phone" required>
                  <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
               </div>
               
               <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                  <select name="nationality" class="form-control has-feedback-left" required>
                     @include('layouts.paises')
                  </select>
                  <span class="fa fa-globe form-control-feedback left" aria-hidden="true"></span>
               </div>

               <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                  <textarea name="address" id="inputSuccess3"  class='form-control has-feedback-left' placeholder='Address' required></textarea>
                  <span class="fa fa-map-marker form-control-feedback left" aria-hidden="true"></span>
               </div>


                <div class="form-group">
                <div class="col-xs-12 ">
                    <button type="submit" class="btn btn-success btn-lg left">Submit</button>
                </div>
                </div>

            </form>
            </div>
     
         
     
     </div>
     

   </div>
   <div class="col-md-5">
      <div class="alert alert-info fade in" role="alert">
         Por favor, rellene el formulario para registrar un nuevo empleado.
      </div>
      @include('usuarios.partials.error')

      @if(Session::has('message'))
         <div class="alert alert-info alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
            @if(Session::has('user'))
            El usuario <strong>{{Session::get('user')}}<strong> ya está registrado en nuestro sistema, ¿Desea enviarle una invitación? <br>
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
@endsection
