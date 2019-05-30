<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Devolucion;
use App\DetalleDevolucion;

class DevolucionController extends Controller
{
    public function index(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
        
        $buscar = $request->buscar;
        $criterio =$request->criterio;

        if($buscar==''){
            $devoluciones = Devolucion::join('users','devoluciones.idusuario','=','users.id')
            ->join('servicios','devoluciones.idservicio','=','servicios.id')
            ->select('devoluciones.id','devoluciones.fecha','devoluciones.observaciones','devoluciones.status',
            'users.usuario','devoluciones.idservicio')
            ->orderBy('devoluciones.id','desc')->paginate(5); 
        }else{
            $devoluciones = Devolucion::join('users','devoluciones.idusuario','=','users.id')
            ->join('servicios','devoluciones.idservicio','=','servicios.id')
            ->select('devoluciones.id','devoluciones.fecha','devoluciones.observaciones','devoluciones.status',
            'users.usuario','devoluciones.idservicio')
            ->where('devoluciones.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('devoluciones.id','desc')->paginate(5);
        }

        

        return [
            'pagination'=>[
                'total'       =>$devoluciones->total(),
                'current_page'=>$devoluciones->currentPage(),
                'per_page'    =>$devoluciones->perPage(),
                'last_page'   =>$devoluciones->lastPage(),
                'from'        =>$devoluciones->firstItem(),
                'to'          =>$devoluciones->lastItem(),
            ],
            'devoluciones'=>$devoluciones
        ];
    }

    public function obtenerCabecera(Request $request){
        if(!$request->ajax()) return redirect('/');
        
        $id = $request -> id;
        $devolucion = Devolucion::join('users','devoluciones.idusuario','=','users.id')
        ->join('servicios','devoluciones.idservicio','=','servicios.id')
        ->select('devoluciones.id','devoluciones.fecha','devoluciones.observaciones','devoluciones.status',
        'users.usuario','devoluciones.idservicio')
        ->where('devoluciones.id','=',$id)
        ->orderBy('devoluciones.id','desc')->take(1)->get();

            return ['devolucion'=>$devolucion];
    } 

    public function obtenerDetalles(Request $request){
        if(!$request->ajax()) return redirect('/');
        
        $id = $request -> id;
        $detalles = DetalleDevolucion::join('insumos','detalle_devoluciones.idinsumo','=','insumos.id')
            ->select('detalle_devoluciones.cantidad',
            'insumos.nombre')
            ->where('detalle_devoluciones.iddevolucion','=',$id)
            ->orderBy('detalle_devoluciones.id','desc')->get();

            return ['detalles'=>$detalles];
    }


    public function store(Request $request){
        if(!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();

            $mytime = Carbon::now('America/Monterrey');

            $devolucion = new Devolucion();
            $devolucion->fecha = $mytime->toDateString();
            $devolucion->idservicio = $request->idservicio;
            $devolucion->idusuario = \Auth::user()->id;
            $devolucion->observaciones = $request->observaciones;
            $devolucion->status = '0';
            $devolucion->save();

            $detalles=$request->data;

            foreach ($detalles as $ep => $det) {
                $detalle = new DetalleDevolucion();
                $detalle->iddevolucion = $devolucion->id;
                $detalle->idinsumo = $det['idinsumo'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->save();
            }

           

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }


    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $devolucion = Devolucion::findOrFail($request->id);
        $devolucion->status = '0';
        $devolucion->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $devolucion = Devolucion::findOrFail($request->id);
     
        $devolucion->status = '1';
        $devolucion->save();
    }
}
