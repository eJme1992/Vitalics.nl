@if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade in" role="alert">
         <ul>
               @foreach ($errors->all() as $error)
                  <li>
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                     {{ $error }}
                  </li>
               @endforeach
         </ul>
      </div>
   @endif