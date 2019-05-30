<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\vehiculo;

class VehiculoController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        
        $buscar = $request->buscar;
        $criterio =$request->criterio;

        if($buscar==''){
            $vehiculos = vehiculo::orderBy('id','desc')->paginate(5);
        }else{
            $vehiculos = vehiculo::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(5);
        }

        

        return [
            'pagination'=>[
                'total'       =>$vehiculos->total(),
                'current_page'=>$vehiculos->currentPage(),
                'per_page'    =>$vehiculos->perPage(),
                'last_page'   =>$vehiculos->lastPage(),
                'from'        =>$vehiculos->firstItem(),
                'to'          =>$vehiculos->lastItem(),
            ],
            'vehiculos'=>$vehiculos
        ];
    }
    public function store(Request $request)
    {
        
        if(!$request->ajax()) return redirect('/');
        $vehiculos = new vehiculo();
        $vehiculos->placas = $request->placas;
        $vehiculos->marca = $request->marca;
        $vehiculos->kilometraje = $request->kilometraje;
        $vehiculos->color = $request->color;
        $vehiculos->capacidad = $request->capacidad;
        $vehiculos->costorenta = $request->costorenta;
        $vehiculos->status = '1';
        $vehiculos->save();

    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $vehiculos = vehiculo::findOrFail($request->id);
        $vehiculos->placas = $request->placas;
        $vehiculos->marca = $request->marca;
        $vehiculos->kilometraje = $request->kilometraje;
        $vehiculos->color = $request->color;
        $vehiculos->capacidad = $request->capacidad;
        $vehiculos->costorenta = $request->costorenta;
        $vehiculos->status = '1';
        $vehiculos->save();
    }
    public function selectVehiculo(Request $request){
        $vehiculos = vehiculo::where('status','=','1')
        ->select('id','placas')
        ->orderBy('placas','asc')->get();

        return ['vehiculos' => $vehiculos];
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $vehiculos = vehiculo::findOrFail($request->id);
        $vehiculos->status = '0';
        $vehiculos->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $vehiculos = vehiculo::findOrFail($request->id);
        $vehiculos->status = '1';
        $vehiculos->save();
    }

    public function selectVehicu(Request $request){
        if(!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $vehiculos = vehiculo::where('placas','like','%'.$filtro.'%')
        ->orWhere('marca','like','%'.$filtro.'%')
        ->select('id','placas','kilometraje','costorenta')
        ->orderBy('placas','asc')->get();

        return ['vehiculos'=>$vehiculos];
    }
}
