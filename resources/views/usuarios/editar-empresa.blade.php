@extends('layouts.app')
@section('content')
<div class="container">
     
   <div class="row">
       @include('usuarios.partials.error')
      @include('usuarios.partials.message')
    <div class="col-md-7 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
            <h2>Company Data</h2>
            
            <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <form id="editar_usuario" enctype="multipart/form-data" method='POST' class="form-horizontal form-label-left input_mask">
               @csrf
                @method('PUT')
            <div class="col-md-12 col-xs-12 col-sm-12 mg-b">
               <center>   
                @if($user->profile == '')
                <img src="{{url('/')}}/img/profile.png" class="img-prueba"  id="img-prueba">
                @else
                <img src="{{url('/')}}{{$user->profile}}"  class="img-prueba" id="img-prueba" />
                @endif
                <div  id="preview"></div>
                <button  type="button" id="change-photo" class="btn btn-profile">Change Logo</button>
                <input type="file" class="form-control hide" name="profile" id="photo"  />
                </center>
            </div>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                  <input type="text"  value="{{$user->name}}" name='name' class="form-control has-feedback-left" id="inputSuccess2" placeholder="Company's Name" required/>
                  <span class="fa fa-briefcase form-control-feedback left" aria-hidden="true"></span>
               </div>

               <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                  <input type="text" class="form-control" readonly value="{{$user->email}}" name='email' id="inputSuccess3" placeholder="Email" required='required' >
                  <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
               </div>
            
               <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                  <input type="text"  value="{{$empresa->rif}}"  class="form-control disabled has-feedback-left" id="inputSuccess2" placeholder="Rif" required readonly/>
                  <span class="fa fa-barcode form-control-feedback left" aria-hidden="true"></span>
               </div>
               <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                  <input type="text" class="form-control" id="inputSuccess5" name="phone" value='{{$user->phone}}' placeholder="Phone" required />
                  <span class="fa fa-phone form-control-feedback right" aria-hidden="true"/></span>

               </div>

               
               <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                  <select name="nationality" class="form-control has-feedback-left" required>
                     @include('layouts.paises')
                  </select>
                  <span class="fa fa-globe form-control-feedback left" aria-hidden="true"></span>
               </div>

               
               <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                  <textarea name="address" id="inputSuccess3"  class='form-control has-feedback-left' placeholder='Address' required>{{$user->address}}</textarea>
                  <span class="fa fa-map-marker form-control-feedback left" aria-hidden="true"></span>
               </div>
               <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                  <textarea name="descripcion" id="inputSuccess3"  class='form-control has-feedback-left' placeholder='Description' required>{{$empresa->descripcion}}</textarea>
                  <span class="fa fa-exclamation-circle form-control-feedback left" aria-hidden="true"></span>
               </div>
               <div class="col-lg-12">
                  <div id="resultadoeditar_usuario"></div>
               </div>
               <div class="form-group">
                  <div class="col-xs-12 " id="botoneditar_usuario">
                     <a name="enviareditar_usuario" id="enviareditar_usuario" class="btn-dark btn-block btn" href="javascript:editar(1)">
                     Submit <i class="fas fa-check"></i></a>
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
	            <form  id="editar_pass" method='POST' class='form-horizontal form-label-left'>
	               @csrf
	               @method('PUT')
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
	                  <div class="col-lg-12">
	                     <div id="resultadoeditar_pass"></div>
	               </div>
	           </div>
	               <div class="row">
	               <div class="col-xs-8"></div>
	               <div class='col-xs-1'>
	                  <div class="form-group">
	                     <a href="javascript:editar(2)" class="btn btn-success btn-lg left">Submit</a>
	                  </div>
	                </div>
	               </div>
	               
	            </form>
	          </div>
	       </div>
	    </div>
   </div>
</div>


@endsection
@section('footer')
</script>
<script type="text/javascript">
    var photo=document.getElementById("photo");
    var btn_change = document.getElementById("change-photo");
    btn_change.addEventListener("click",()=>{photo.click()});
    var photoT=document.getElementById("img-prueba");
     var btn_C = document.getElementById('change-photo');
     var cont = 1;
     photo.onchange = function(e) {
     // Creamos el objeto de la clase FileReader
      let reader = new FileReader();
   
     // Leemos el archivo subido y se lo pasamos a nuestro fileReader
     reader.readAsDataURL(e.target.files[0]);
     
     // Le decimos que cuando este listo ejecute el código interno
     reader.onload = function(){
        btn_C.value = cont;
       let preview = document.getElementById('preview');
         image = document.createElement("img");
         console.log(btn_C.value);
     if( btn_C.value == 1){ 
       image.src = reader.result;
       image.classList.add("img-p", "img-circle");
       photoT.style.display ="none";  
       preview.appendChild(image);
         }  else {
        preview.firstChild.src = reader.result;
     }
    cont++;
     };

}
</script>
<script type="text/javascript">
    function editar(op){
    if(op===1){  
      
             PFEditar('{{route('usuarios.update', $user->id)}}','editar_usuario',op);
          }
    if(op===2){  
      
             PFEditar('{{route('usuarios.update', $user->id)}}','editar_pass',op);
     }      
    };


    
    
    function PFEditar(url,formulario,op){
        var formData=new FormData(jQuery('#'+formulario)[0]);
        var html='<a name="enviar'+formulario+'" id="enviar'+formulario+'" class="btn-dark btn-block btn" href="javascript:editar('+op+')" >Submit <i class="fas fa-check"></i></a>';
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
                }
            })
            .done(function(data,textStatus,jqXHR){
                var getData=jqXHR.responseJSON;
                if(data.status=='ok'){
                    $("#resultado"+formulario).html('<div class="alert alert-success">'+data.mensaje+' | <a href="javascript:location.reload();">Refresh</a></div>');
                    $("#boton"+formulario).html(html);
                }else{
                    $("#resultado"+formulario).html('<div class="alert alert-danger"><strong>ERROR! </strong>'+data.mensaje+'</div>');
                    $("#boton"+formulario).html(html);
                }
            })
            .fail(function(data,textStatus,errorThrown){
                var errorsHtml='';var errors=data.responseJSON;
                $.each(errors,function(key,value){
                    if(key!='message'){
                        $.each(value,function(key1,value1){
                            errorsHtml+=value1;
                        });
                    }});
                    $("#resultado"+formulario).html('<div class="alert alert-danger"><strong>ERROR! </strong>'+errorsHtml+'</div>');
                    $("#boton"+formulario).html(html);
            })
        };
</script>
@endsection
