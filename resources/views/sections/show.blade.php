@extends('layouts.app')
@section('css')
<link href='{{asset("")}}js/calender/packages/core/main.css' rel='stylesheet' />
<link href='{{asset("")}}js/calender/packages/daygrid/main.css' rel='stylesheet' />
<link href='{{asset("")}}js/calender/packages/timegrid/main.css' rel='stylesheet' />
<link href='{{asset("")}}js/calender/packages/list/main.css' rel='stylesheet' />
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card-header"><h4>Section: <b>{{$servicio->nombre}}</b></h4></div>
         <hr>
         <h4>Descriptions</h4>
         {{$section->descripcion}}
       
        </div>
        <div class="col-md-2">
        <div class="card-header"><h4>Date</h4></div>
         <hr>
         <ul>
         @foreach($fechas as $fecha)
         <li>{{$fecha->fecha}} ( {{$fecha->hora}} )</li>       
        @endforeach
         </ul>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header"><h4>Section</h4></div>
                <hr>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @include('usuarios.partials.message')
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
       
       
        
    </div>
</div>
@endsection

@section('footer')
<script src='{{asset("")}}js/calender/packages/core/main.js'></script>
<script src='{{asset("")}}js/calender/packages/interaction/main.js'></script>
<script src='{{asset("")}}js/calender/packages/daygrid/main.js'></script>
<script src='{{asset("")}}js/calender/packages/timegrid/main.js'></script>
<script src='{{asset("")}}js/calender/packages/list/main.js'></script>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      defaultDate: '<?= date("Y-m-d");?>',
      navLinks: true, // can click day/week names to navigate views
      businessHours: true, // display business hours
      editable: true,
      events: [
        @foreach($fechas as $fecha)
        {
          title: '{{$servicio->nombre}}',
          start: '{{$fecha->fecha}}',
          constraint: '{{$servicio->nombre}}'
          //start: '2019-06-18',
         // end: '2019-06-20'
        },
        @endforeach
      ]
    });

    calendar.render();
  });

</script>
@endsection
