<?php

namespace App\Http\Controllers;

use App\FuncionesRepetitivas;
use App\Servicio;
use App\User;
use App\section;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiciosController extends Controller
{

    public function __construct()
    {
        header('Origin: xxx.com');
        header('Access-Control-Allow-Origin:*');

    }

    public function todosmisservicios()
    {
        $servicio = Servicio::all();
        return response()->json($servicio, 200);
    }

    public function nuevoservicio(Request $request)
    {

        $validatedData = $request->validate(['file' => 'required|image', 'nombre' => 'required', 'tipo' => 'required', 'sesiones' => 'required', 'costo' => 'required', 'descripcion' => 'required']);

        if ($request->file('file')) {
            $file = $request->file('file');
            $name = time() . $file->getClientOriginalName();
            $fn   = new FuncionesRepetitivas();
            $name = $fn->limpiarCaracteresEspeciales($name);
            $file->move(public_path() . '/img/programa/servicio/', $name);
            $name = '/img/programa/servicio/' . $name;
        } else {
            $name = public_path() . "/img/programa/servicio/profile.png";
        }

        $servicio              = new Servicio();
        $servicio->nombre      = $request->input('nombre');
        $servicio->sesiones    = $request->input('sesiones');
        $servicio->costo       = $request->input('costo');
        $servicio->imagen      = $name;
        $servicio->estado      = 'activo';
        $servicio->tipo        = $request->input('tipo');
        $servicio->descripcion = $request->input('descripcion');
        $servicio->save();

        return response()->json(['mensaje' => 'Record created with success', 'status' => 'ok'], 200);

    }
    public function verservicio($id)
    {
        $servicio = Servicio::where('id', $id)->first();
        return response()->json(['datos' => $servicio, 'status' => 'ok'], 200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $servicios = Servicio::paginate(8);
        return view('servicios.services-list', compact(['servicios']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filtros(Request $request)
    {
        if (!$request->input('filtros')) {

            $servicios = DB::table('servicios')
                ->where('nombre', 'like', $request->buscar . '%')
                ->paginate();

            return view('servicios.services-list', compact(['servicios']));

        } else {
            #Si esta usando algun filtro pasara por aqui

            // dd($request);
            if ($request->input('filtros.price') == true and $request->input('filtros.fecha') == true and $request->input('filtros.tipo') == true) {
                #ACTIVOS TODOS

                $price = explode(';', $request->price);

                $fecha  = explode('-', $request->fecha);
                $fI     = trim($fecha[0]);
                $fF     = trim($fecha[1]);
                $fechaI = converFecha($fI);
                $fechaF = converFecha($fF);

                $servicios = DB::table('servicios')
                    ->where(['tipo' => $request->tipo])
                    ->whereBetween('created_at', [$fechaI, $fechaF])
                    ->whereBetween('costo', [$price[0], $price[1]])->paginate();

                return view('servicios.services-list', compact(['servicios']));

            } elseif ($request->input('filtros.price') == true and $request->input('filtros.fecha') == true) {
                ##PRECIO Y FECHA

                $price = explode(';', $request->price);

                $fecha  = explode('-', $request->fecha);
                $fI     = trim($fecha[0]);
                $fF     = trim($fecha[1]);
                $fechaI = converFecha($fI);
                $fechaF = converFecha($fF);

                $servicios = DB::table('servicios')
                    ->whereBetween('created_at', [$fechaI, $fechaF])
                    ->whereBetween('costo', [$price[0], $price[1]])->paginate();

                return view('servicios.services-list', compact(['servicios']));

            } elseif ($request->input('filtros.tipo') == true and $request->input('filtros.fecha') == true) {
                ##FECHA Y TIPO

                $fecha  = explode('-', $request->fecha);
                $fI     = trim($fecha[0]);
                $fF     = trim($fecha[1]);
                $fechaI = converFecha($fI);
                $fechaF = converFecha($fF);

                $servicios = DB::table('servicios')
                    ->where(['tipo' => $request->tipo])
                    ->whereBetween('created_at', [$fechaI, $fechaF])->paginate();

                return view('servicios.services-list', compact(['servicios']));

            } elseif ($request->input('filtros.price') == true and $request->input('filtros.tipo') == true) {
                ##PRECIO Y TIPO
                $price = explode(';', $request->price);

                $servicios = DB::table('servicios')
                    ->where(['tipo' => $request->tipo])
                    ->whereBetween('costo', [$price[0], $price[1]])->paginate();

                return view('servicios.services-list', compact(['servicios']));

            } elseif ($request->input('filtros.fecha')) {
#si se activo solo el filtro de fecha

                $fecha  = explode('-', $request->fecha);
                $fI     = trim($fecha[0]);
                $fF     = trim($fecha[1]);
                $fechaI = converFecha($fI);
                $fechaF = converFecha($fF);

                $servicios = DB::table('servicios')->whereBetween('created_at', [$fechaI, $fechaF])->paginate();

                return view('servicios.services-list', compact(['servicios']));

            } elseif ($request->input('filtros.tipo')) {
#si se activo solo el filtro del tipo

                $servicios = DB::table('servicios')->where(['tipo' => $request->tipo])->paginate();

                return view('servicios.services-list', compact(['servicios']));

            } elseif ($request->input('filtros.price')) {
#si se activo solo el filtro del precio

                $price = explode(';', $request->price);

                $servicios = DB::table('servicios')->whereBetween('costo', [$price[0], $price[1]])->paginate();

                // dd($servicios);
                return view('servicios.services-list', compact(['servicios']));

            }

        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $servicio = Servicio::findOrFail($id);

        $empresaID = empresaID(Auth::user()->id);

        if ($empresaID) {
            $sectionsUser = Auth::user()->company->empresa->sections;
        }else{
            $sectionsUser = false;
        }

        

        $sectionsPublic = section::where('lugar','Salons')->get();

        $usuarios = User::
            join('empresa_user', 'empresa_user.user_id', '=', 'users.id')->
            join('empresas', 'empresas.id', '=', 'empresa_user.empresa_id')->
            select('users.*', 'empresa_user.*')->
            where('empresas.id', $empresaID)->
            where('users.model', 'natural')->
            where('empresa_user.estado', 'activo')->
            get();

        //dd($usuarios);

        return view('servicios.show', ['servicio' => $servicio, 'usuarios' => $usuarios,'sectionsUser' => $sectionsUser,'sectionsPublic' => $sectionsPublic]);
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
