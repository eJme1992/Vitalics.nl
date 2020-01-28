<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
 
        $user = User::where('id',Auth::user()->id)->first();
     
        if ($user->model == 'juridico') {
        $empresaID = empresaID(Auth::user()->id);
        $servicios = DB::table('fechas')   
        ->join('sections','fechas.seccion_id', '=','sections.id')   
        ->join('servicios','servicios.id', '=','sections.servicio_id') 
        //->join('section_user','section_user.sections_id', '=','sections.id')   
        ->where('sections.empresa_id',$empresaID)
        ->where('fechas.fecha','>',date("Y-m-d",strtotime(date('Y-m-d')."- 4 week"))) 
        ->select('sections.id AS id','fechas.fecha AS fecha','fechas.hora AS hora','servicios.nombre',
        'servicios.costo','sections.descripcion','sections.lugar','sections.cupos','sections.estado')
        ->get();
        }else{
            $servicios = DB::table('fechas')   
            ->join('sections','fechas.seccion_id', '=','sections.id')   
            ->join('servicios','servicios.id', '=','sections.servicio_id') 
            ->join('section_user','section_user.sections_id', '=','sections.id')   
            ->where('section_user.user_id',Auth::user()->id)
            ->where('fechas.fecha','>',date("Y-m-d",strtotime(date('Y-m-d')."- 4 week"))) 
            ->select('sections.id AS id','fechas.fecha AS fecha','fechas.hora AS hora','servicios.nombre',
            'servicios.costo','sections.descripcion','sections.lugar','sections.cupos','sections.estado')
            ->get();


        }
        //dd($servicios);
         return view('home', ['servicios' => $servicios]);
    }
}
