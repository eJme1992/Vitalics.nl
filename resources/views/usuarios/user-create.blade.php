@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row">
   	<form id="new-user" name="new-user" onsubmit="realizaProceso();return false;">
      <div class="col-md-12 mg-b">
         <center>
            <h1 class="title">Welcome to your profile</h1>
         </center>
      </div>
      <div class="col-md-12 mg-b">
      	<img src="{{url('/')}}/img/profile.png" class="img-prueba" id="img-prueba">
         <div  id="preview"></div>
         <button  type="button" id="change-photo" class="btn btn-profile">Change profile photo</button>
         <input type="file" class="form-control hide" name="profile" id="profile"  />
      </div>
      <div class="col-md-6 mg-b">
         <p>Full Name</p>
         <input type="text" class="form-control" name="name" id="name" value="Name" required="">
      </div>
      <div class="col-md-6 mg-b">
         <p> Email</p>
         <input type="email" name="email" id="email" class="form-control" placeholder="hola@example.com" required="">
      </div>
      <div class="col-md-6 mg-b">
         <p>Password</p>
         <input type="Password" name="" class="form-control" required="" id="password" name="password">
      </div>
         <input type="hidden" name="model" id="model" class="form-control" value="natural" />
    
      <div class="col-md-6 mg-b">
         <p>Date of birth</p>
         <input type="date" name="birhdate" id="birhdate" class="form-control">
      </div>
      <div class="col-md-6 mg-b">
         <p>Nationality</p>
         <select name="nationality" id="nationality" class="form-control">
            @include('layouts.paises')
         </select>
      </div>
      <div class="col-md-6 mg-b">
         <p>Cellphone</p>
         <input type="text" name="phone" maxlength='9' id="phone" class="form-control"/>
      </div>
      <div class="col-md-12">
         <p>Address</p>
         <textarea class="form-control" id="address" name="address"></textarea>
      </div>
      <div id="resultado"></div>
      <div class="col-md-12"><button type="submit" class="btn btn-success update-btn">Update</button></div>
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
<script type="text/javascript"> 
  function realizaProceso() {
         
             var msj = '1'; 
         //validaciones con js
         
         if (msj === "1") { //tres igual para decir que es identico
         var formData = new FormData(jQuery('#new-user') [0]); //Se crea el arreglo con los datos del form
         $.ajax({
           url: '{{url('usuarios')}}', // Al controlador donde van mis datos 
           type: 'POST', 
           contentType: false,
           processData: false, //Le dice que tipo de dato va a recibir
           dataType: 'json',
           data: formData,  
           beforeSend: function() {
             $("#resultado").html('<div class="alert alert-success">Procesando...!</div>');
           }
         })
         .done(function(data, textStatus, jqXHR) {
           var getData = jqXHR.responseJSON; // guarda los errores si los hay en la ejecucion del js
         
           if(data.status=='ok'){ //ver controlador, status es el nombre la clave cuando se creo
            $("#resultado").html('<div class="alert alert-success">'+data.mensaje+'</div>'); 
             document.getElementById("newcrm").reset();
           }else{
           $("#resultado").html('<div class="alert alert-danger"><strong>ERROR!</strong>'+data.error+'</div>');
           }
         })
                .fail(function(data, textStatus, errorThrown) { //Si ocurre errores el jquery
                    var errorsHtml = '';
                                var errors = data.responseJSON;
                                $.each(errors, function (key, value) {
                                   if(key!='message') {
                                    $.each(value, function (key1, value1){
                                    errorsHtml += value1;
                                  });
                                  }
                                });
                                
                 $("#resultado1").html('<div class="alert alert-danger"><strong>ERROR! </strong>'+errorsHtml +' </div>');        
               })
          // Fin de ajax
          } else {
              swal("¡Error! ", msj, "error");
          }
           };
</script>
@endsection