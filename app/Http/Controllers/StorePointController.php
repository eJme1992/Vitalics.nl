<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PuntosComprados;
use App\StorePoint;
use App\Payment;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Auth;

class StorePointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $point = StorePoint::first();
        $payment = Payment::where('user_id',Auth::user()->id)->get();

        return view('point.create',['point' => $point,'payment'=> $payment]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());

             try {
              Stripe::setApiKey(config('services.stripe.secret'));
                $customer = Customer::create(array(
                    'email' => $request->stripeEmail,
                    'source'  => $request->stripeToken
                ));

                $charge = Charge::create(array(
                    'customer' => $customer->id,
                    'amount'   => $request->price,
                    'currency' => 'eur'
                ));


                $payment = new Payment;
                $payment->user_id = Auth::user()->id;
                $payment->id_pay = $customer->id;
                $payment->email = $customer->email;
                $payment->default_source = $customer->default_source;
                $payment->invoice_prefix = $customer->invoice_prefix;
                $payment->purchased_points = $request->points;
                $payment->money_paid = $request->price;

                $user = PuntosComprados::where('usuario_id',Auth::user()->id)->first();

                $user->puntos = $user->puntos +  $request->points;

                if ($payment->save() && $user->save()) {
                      return back()->with('message','You have registered your payment correctly');
                }

            } catch (\Exception $ex) {

                return back()->with('message',$ex->getMessage());
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
