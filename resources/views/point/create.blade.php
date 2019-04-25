@extends('layouts.app') @section('content')
<div class="container">

    <div class="row">
        <div class="col-md-7 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Buy Points</h2>
                    <h5 class='pull-right'> 1 point = {{$point->price}}$</h5>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @if(Session::has('message'))
                    <div class="alert alert-info alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">×</span>
                      </button> {{Session::get('message')}}
                    </div>
                    @endif
                    <form id="myForm" action="{{route('point.store')}}" enctype="multipart/form-data" method='POST' class="form-horizontal form-label-left input_mask">
                        {{ csrf_field() }}
                        <input type="hidden" id="stripeToken" name="stripeToken" />
                        <input type="hidden" id="stripeEmail" name="stripeEmail" />
                        <input type="hidden" name="price" id="price">
                        <div class="col-md-9 col-sm-12 col-xs-12 form-group has-feedback">
                            <input type="number" name='points' class="form-control has-feedback-left" id="points" placeholder="Points" required>
                            <span style="margin-top: 6px;" class="fa fa-money form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      
                            <div class="col-md-3 ">
                                <button type="submit" id="customButton" disabled class="btn btn-success btn-md left">Buy 
                                   <i class="fas fa-shopping-cart"></i></button>
                            </div>
                        
                    </form>
                </div>
            </div>


        </div>
        <div class="col-md-5">
            <div class="alert alert-info fade in" role="alert">
                My orders
            </div>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Payment Nro</th>
                        <th>Date</th>
                        <th>Points</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payment as $p)
                    <tr>
                        <td>{{$p->id_pay}}</td>
                        <td>{{$p->id_pay}}</td>
                        <td>{{$p->default_source}}</td>
                        <td>{{$p->purchased_points}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
  </div>
    @endsection @section('footer')
    <script>
        var handler = StripeCheckout.configure({
            key: '{{env('STRIPE_KEY')}}',
            image: '{{url('/')}}/panel/logo.png',
            token: function(token) {
                $("#stripeToken").val(token.id);
                $("#stripeEmail").val(token.email);
                $("#myForm").submit();
            }
          });
        
            $('#points').keyup(function(){
                if($(this).val().length !=0)
                    $('#customButton').attr('disabled', false);            
                else
                    $('#customButton').attr('disabled',true);
            });
        
          $('#customButton').on('click', function(e) {
            // var amount = $("#points").val() / {{$point->price}} * 100 ;
            var amount = $("#points").val() * {{$point->price}} ;
            $("#price").val(amount);
            // Open Checkout with further options
            handler.open({
              name: 'Puntos Vitalics',
              //description: ''+amount+' widgets ('+amount+')',
              amount: amount,
              currency: '{{$point->currency}}'
            });
            e.preventDefault();
          });
        
          // Close Checkout on page navigation
          $(window).on('popstate', function() {
            handler.close();
          });
    </script>
    @endsection