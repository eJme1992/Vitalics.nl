@extends('layouts.app')
@section('content')
<div class="container">

   <div class="row">
    <div class="col-md-7 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
            <h2>Datos de la empresa</h2>
            
            <div class="clearfix"></div>
            </div>
            <div class="x_content">
            @foreach($usuario as $user)
            

            <form action="{{route('usuarios.update', $user->id)}}" enctype="multipart/form-data" method='POST' class="form-horizontal form-label-left input_mask">
               @csrf
                @method('PUT')
            <div class="col-md-12 col-xs-12 col-sm-12 mg-b">
               <center>   
                @if($user->profile == '')
                <img src="{{url('/')}}/img/profile.png" class="img-prueba"  id="img-prueba">
                @else
                <img src="{{$user->profile}}"   class="img-prueba" id="img-prueba">
                @endif
                <div  id="preview"></div>
                <button  type="button" id="change-photo" class="btn btn-profile">Change Logo</button>
                <input type="file" class="form-control hide" name="profile" id="photo"  />
                <center>
            </div>
               <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                  <input type="text"  value="{{$user->name}}" name='name' class="form-control has-feedback-left" id="inputSuccess2" placeholder="Company's Name" required>
                  <span class="fa fa-briefcase form-control-feedback left" aria-hidden="true"></span>
               </div>

               <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                  <input type="text" class="form-control" value="{{$user->email}}" name='email' id="inputSuccess3" placeholder="Email" required='required' >
                  <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
               </div>
                @foreach($empresa as $empresa)
               <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback">
                  <input type="text"  value="{{$empresa->rif}}"  class="form-control disabled has-feedback-left" id="inputSuccess2" placeholder="Rif" required disabled>
                  <span class="fa fa-barcode form-control-feedback left" aria-hidden="true"></span>
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
                  <textarea name="address" id="inputSuccess3"  class='form-control has-feedback-left' placeholder='Address' required>{{$user->address}}</textarea>
                  <span class="fa fa-map-marker form-control-feedback left" aria-hidden="true"></span>
               </div>
               <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                  <textarea name="descripcion" id="inputSuccess3"  class='form-control has-feedback-left' placeholder='Description' required>{{$empresa->descripcion}}</textarea>
                  <span class="fa fa-exclamation-circle form-control-feedback left" aria-hidden="true"></span>
               </div>
                <div class="form-group">
                <div class="col-xs-12 ">
                    <button type="submit" class="btn btn-success btn-lg left">Submit</button>
                </div>
                </div>
               @endforeach

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
            <form action="{{route('usuarios.update', $user->id)}}" method='POST' class='form-horizontal form-label-left'>
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
                     <input type="password" name='password2' class="form-control" required>
                  </div>
               </div>
               @if($message != '')
               <span class="label label-danger">{{$message}}</span>
               @endif
               <div class="row">
               <div class="col-xs-8"></div>
               <div class='col-xs-1'>
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
@endforeach
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
