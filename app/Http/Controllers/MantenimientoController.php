<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Mantenimiento;
use App\DetalleMantenimiento;

class MantenimientoController extends Controller
{
    public function index(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
        
        $buscar = $request->buscar;
        $criterio =$request->criterio;

        if($buscar==''){
            $mantenimientos = Mantenimiento::join('users','mantenimientos.idusuario','=','users.id')
            ->join('vehiculos','mantenimientos.idvehiculo','=','vehiculos.id')
            ->select('mantenimientos.id','mantenimientos.fecha','mantenimientos.falla',
            'mantenimientos.diagnostico','mantenimientos.observaciones','mantenimientos.status',
            'users.usuario','vehiculos.placas','vehiculos.kilometraje')
            ->orderBy('mantenimientos.id','desc')->paginate(5); 
        }else{
            $mantenimientos = Mantenimiento::join('users','mantenimientos.idusuario','=','users.id')
            ->join('vehiculos','mantenimientos.idvehiculo','=','vehiculos.id')
            ->select('mantenimientos.id','mantenimientos.fecha','mantenimientos.falla',
            'mantenimientos.diagnostico','mantenimientos.observaciones','mantenimientos.status',
            'users.usuario','vehiculos.placas')
            ->where('mantenimientos.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('mantenimientos.id','desc')->paginate(5);
        }

        

        return [
            'pagination'=>[
                'total'       =>$mantenimientos->total(),
                'current_page'=>$mantenimientos->currentPage(),
                'per_page'    =>$mantenimientos->perPage(),
                'last_page'   =>$mantenimientos->lastPage(),
                'from'        =>$mantenimientos->firstItem(),
                'to'          =>$mantenimientos->lastItem(),
            ],
            'mantenimientos'=>$mantenimientos
        ];
    }

    public function obtenerCabecera(Request $request){
        if(!$request->ajax()) return redirect('/');
        
        $id = $request -> id;
        $mantenimiento = Mantenimiento::join('users','mantenimientos.idusuario','=','users.id')
        ->join('vehiculos','mantenimientos.idvehiculo','=','vehiculos.id')
        ->select('mantenimientos.id','mantenimientos.fecha','mantenimientos.falla',
        'mantenimientos.diagnostico','mantenimientos.observaciones','mantenimientos.status',
        'users.usuario','vehiculos.placas','vehiculos.kilometraje')
        ->where('mantenimientos.id','=',$id)
        ->orderBy('mantenimientos.id','desc')->take(1)->get();

            return ['mantenimiento'=>$mantenimiento];
    }

    public function obtenerDetalles(Request $request){
        if(!$request->ajax()) return redirect('/');
        
        $id = $request -> id;
        $detalles = DetalleMantenimiento::join('insumos','detalle_mantenimientos.idinsumo','=','insumos.id')
            ->select('detalle_mantenimientos.cantidad',
            'insumos.nombre')
            ->where('detalle_mantenimientos.idmantenimiento','=',$id)
            ->orderBy('detalle_mantenimientos.id','desc')->get();

            return ['detalles'=>$detalles];
    }


    public function store(Request $request){
        if(!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();

            $mytime = Carbon::now('America/Monterrey');

            $mantenimiento = new Mantenimiento();
            $mantenimiento->fecha = $mytime->toDateString();
            $mantenimiento->idvehiculo = $request->idvehiculo;
            $mantenimiento->idusuario = \Auth::user()->id;
            $mantenimiento->falla = $request->falla;
            $mantenimiento->diagnostico = $request->diagnostico;
            $mantenimiento->observaciones = $request->observaciones;
            $mantenimiento->status = '0';
            $mantenimiento->save();

            $detalles=$request->data;

            foreach ($detalles as $ep => $det) {
                $detalle = new DetalleMantenimiento();
                $detalle->idmantenimiento = $mantenimiento->id;
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
        $mantenimiento = Mantenimiento::findOrFail($request->id);
        $mantenimiento->status = '0';
        $mantenimiento->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $mantenimiento = Mantenimiento::findOrFail($request->id);
     
        $mantenimiento->status = '1';
        $mantenimiento->save();
    }
}
