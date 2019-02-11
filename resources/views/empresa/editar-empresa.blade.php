@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row">
      <div id="hide">
      	 <div class="col-md-12 mg-b">
         <center>
            <h1 class="title">Edit Company</h1>
         </center>
      </div>
      <div class="col-md-6 mg-b">
      	<p>Company's Name</p>
      	<input type="text" class="form-control" name="rif" placeholder="Vivaldi Violin">
      </div>
      <div class="col-md-6 mg-b">
      	<p>Rif</p>
      	<input type="text" class="form-control" name="rif" placeholder="J:158756-9">
      </div>
      <div class="col-md-12 mg-b">
      	<p>Description</p>
      	<textarea name="Description" class="form-control" ></textarea>
      </div>
      <div class="col-md-12">
      	<button type="button" class="btn btn-success update-btn" id="siguiente" onclick="ocul()">Next</button>
      </div>
  </div>
  	<div class="body-formu hide" id="formu">
			<p> Email</p>
			<input type="email" class="form-control mg-b" name="email" placeholder="your@mail.com" />
			<p>Password</p>
			<input type="password" class="form-control" name="email" />
			<button type="Submit" class="btn btn-success update-btn" >Submit</button>
		</div>
</div>
</div>

@endsection
@section('footer')
<script type="text/javascript">
	
	 function ocul(){
		 document.getElementById("formu").classList.remove("hide");
		 	document.getElementById("hide").style.display="none";
	} 
	  

</script>
@endsection