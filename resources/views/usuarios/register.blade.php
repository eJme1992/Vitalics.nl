@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row">
				<div class="col-md-12 mg-b">
					<center><h1 class="title">Welcome to your profile</h1></center>
				</div>
				<div class="col-md-12 mg-b">
					<div  id="preview"></div>
				<p>Foto de perfil</p>
				<input type="file" class="form-control" name="photo" id="photo"/>
			</div>
			<div class="col-md-6 mg-b">
				<p>User Name:</p>
				<input type="text" class="form-control" name="user-name" value="User Name">
			</div>
			<div class="col-md-6 mg-b">
				<p>User Lastname</p>
				<input type="text" name="user-name"  class="form-control" value="User Lastname">
			</div>
			<div class="col-md-6 mg-b">
				<p>User Email</p>
				<input type="text" name="user-name" class="form-control" value="hola@example.com">
			</div><div class="col-md-6 mg-b">
				<p>Password</p>
				<input type="Password" name="" class="form-control" value="04152 589452">
			</div>

			<div class="col-md-6 mg-b">
				<p>Tipo</p>
				<input type="text" name="" class="form-control" value="tipo A">
			</div>
			<div class="col-md-6 mg-b">
				<p>Fecha de nacimiento</p>
				<input type="date" name="" class="form-control">
			</div>
			<div class="col-md-6 mg-b">
				<p>Nacionalidad</p>
				<input type="text" name="" class="form-control">
			</div>
			<div class="col-md-6 mg-b">
				<p>Telefono</p>
				<input type="text" name="" class="form-control" value="04152 589452">
			</div>
			
			<div class="col-md-12">
				<p>Dirección</p>
				<textarea class="form-control"></textarea>
			</div>
			<div class="col-md-12"><button type="submit" class="btn btn-success update-btn">Update</button></div>

		</div>
	</div>
@endsection
@section('footer')
<script type="text/javascript">
   document.getElementById("photo").onchange = function(e) {
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
       preview.appendChild(image);
     };
   }
</script>
@endsection