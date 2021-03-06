@extends('layouts.app') @section('content')
<div class="container">

    <div class="row">
        @include('usuarios.partials.error') @include('usuarios.partials.message')
        <div class="col-md-7 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Edit profile</h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    
                    <form class="form-horizontal form-label-left input_mask" id="editar_usuario">

                        @csrf @method('PUT')
                        <div class="col-md-12 col-xs-12 col-sm-12 mg-b">
                            <center>
                                @if($user->profile == '')
                                <img src="{{url('/')}}/img/profile.png" class="img-prueba" id="img-prueba"> @else
                                <img src="{{$user->profile}}" class="img-prueba" id="img-prueba"> @endif
                                <div id="preview"></div>
                                <button type="button" id="change-photo" class="btn btn-profile">Change profile photo</button>
                                <input type="file" class="form-control hide" name="profile" id="photo" />
                            </center>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                            <input type="text" value="{{$user->name}}" name='name' class="form-control has-feedback-left" id="inputSuccess2" placeholder="Name" required>
                            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                            <input type="text" class="form-control" value="{{$user->email}}" name='email' id="inputSuccess3" placeholder="Email" required='required'>
                            <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                            <input type="text" value='{{$user->birthdate}}' data-inputmask="'mask': '9999-99-99'" class="form-control has-feedback-left" id="inputSuccess4" name='birthdate' placeholder="Birthdate" required>
                            <span class="fa fa-birthday-cake form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                            <input type="text" class="form-control" id="inputSuccess5" name='phone' value='{{$user->phone}}' placeholder="Phone" required>
                            <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                            <select name="nationality" class="form-control has-feedback-left" required>
                     @include('layouts.paises')
                  </select>
                            <span class="fa fa-globe form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                            <textarea name="address" id="inputSuccess3" class='form-control has-feedback-left' placeholder='Address' required>{{$user->address}}</textarea>
                            <span class="fa fa-map-marker form-control-feedback left" aria-hidden="true"></span>
                        </div>

                        <div class="col-lg-12">
                            <div id="resultadoeditar_usuario"></div>
                        </div>
                        <div class="form-group">

                            <div class="col-xs-12 " id="botoneditar_usuario">
                                <button onclick type="button" class="btn-dark btn-block btn">Submit <i class="fas fa-check"></i></button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
        <div class="col-md-5 col-xl-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Change Password</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <center>
                        <h1 style='font-size:80px;' class='mg-b'>
                            <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                        </h1>
                    </center>
                    <!--  <form action="{{route('usuarios.update', $user->id)}}" method='POST' class='form-horizontal form-label-left'>-->
                         <form id="newuserr" onsubmit="realizaProceso();return false;" class="form-horizontal form-label-left input_mask">
                        @csrf @method('PUT')
                        <div class="row">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">New Password</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="password" name='password' class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Repeat Password</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="password" name='password_confirmation' id="password-confirm" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-8"></div>
                            <div class='col-xs-1'>
                                <div id="resultado"></div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-lg left">Submit</button>
                                </div>
                            </div>
                        </div>

                    </form>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection @section('footer')
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

    function ProcesarFormularioEditar(url,formulario){
       var formData = new FormData(jQuery('#'+formulario)[0]);
       var html = '<button  type="submit" name="enviar'+formulario+'" id="enviar'+formulario+'" class="btn-dark btn-block btn" >Submit <i class="fas fa-check"></i></button> ';
       $.ajax({
        url:url,
        type:'POST',
        contentType:false,
        processData:false,
        dataType:'json',
        data:formData,
        beforeSend:function(){
        $("#resultado"+formulario).html('<div class="alert alert-success">Procesando...!</div>');   
        $("#boton"+formulario).html('<button disabled=""  type="button" name="enviar'+formulario+'" id="enviar'+formulario+'" class="btn-dark btn-block btn">Submit <i class="fa fa-spinner fa-spin fa-1x fa-fw"></i></button> ');
        }}).done(function(data,textStatus,jqXHR){
            var getData=jqXHR.responseJSON;
            if(data.status=='ok'){

            $("#resultado"+formulario).html('<div class="alert alert-success">'+data.mensaje+' | <a href="#">Recharge</a></div>');
     
            alert(html);
            $("#boton"+formulario).html(html);
            }else{

            $("#resultado"+formulario).html('<div class="alert alert-danger"><strong>ERROR!</strong>'+data.mensaje+'</div>');
            $("#boton"+formulario).html(html);

            }}).fail(function(data,textStatus,errorThrown){
                var errorsHtml='';
                var errors=data.responseJSON;
                $.each(errors,function(key,value){
                    if(key!='message'){
                        $.each(value,function(key1,value1){
                            errorsHtml+=value1;});}});

                $("#resultado"+formulario).html('<div class="alert alert-danger"><strong>ERROR!</strong>'+errorsHtml+'</div>');
                $("#boton"+formulario).html(html);})};
          
</script>

@endsection