<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Servicio;
use App\DetalleServicio;

class ServicioController extends Controller
{
    public function index(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
        
        $buscar = $request->buscar;
        $criterio =$request->criterio;

        if($buscar==''){
            $servicios = Servicio::join('personas','servicios.idcliente','=','personas.id')
            ->join('users','servicios.idusuario','=','users.id')
            ->join('vehiculos','servicios.idvehiculo','=','vehiculos.id')
            ->select('servicios.id','servicios.fecha','servicios.metodopago','servicios.horasservicio',
            'servicios.total','servicios.fechaservicio','servicios.impuesto','servicios.status',
            'personas.nombre','users.usuario','vehiculos.placas','vehiculos.costorenta')
            ->orderBy('servicios.id','desc')->paginate(5); 
        }else{
            $servicios = Servicio::join('personas','servicios.idcliente','=','personas.id')
            ->join('users','servicios.idusuario','=','users.id')
            ->join('chofers','servicios.idchofer','=','chofers.id')
            ->select('servicios.id','servicios.fecha','servicios.metodopago','servicios.horasservicio',
            'servicios.total','servicios.fechaservicio','servicios.impuesto','servicios.status',
            'personas.nombre','users.id','users.usuario','chofers.placas')
            ->where('servicios.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('servicios.id','desc')->paginate(5);
        }

        

        return [
            'pagination'=>[
                'total'       =>$servicios->total(),
                'current_page'=>$servicios->currentPage(),
                'per_page'    =>$servicios->perPage(),
                'last_page'   =>$servicios->lastPage(),
                'from'        =>$servicios->firstItem(),
                'to'          =>$servicios->lastItem(),
            ],
            'servicios'=>$servicios
        ];
    }

    public function obtenerCabecera(Request $request){
        if(!$request->ajax()) return redirect('/');
        
        $id = $request -> id;
        $servicio = Servicio::join('personas','servicios.idcliente','=','personas.id')
            ->join('users','servicios.idusuario','=','users.id')
            ->join('vehiculos','servicios.idvehiculo','=','vehiculos.id')
            ->select('servicios.id','servicios.fecha','servicios.metodopago','servicios.horasservicio',
            'servicios.total','servicios.fechaservicio','servicios.impuesto','servicios.status',
            'personas.nombre','users.usuario','vehiculos.placas','vehiculos.costorenta')
            ->where('servicios.id','=',$id)
            ->orderBy('servicios.id','desc')->take(1)->get();

            return ['servicio'=>$servicio];
    }

    public function obtenerDetalles(Request $request){
        if(!$request->ajax()) return redirect('/');
        
        $id = $request -> id;
        $detalles = DetalleServicio::join('insumos','detalle_servicios.idinsumo','=','insumos.id')
            ->select('detalle_servicios.cantidad','detalle_servicios.precioventa','detalle_servicios.descuento',
            'insumos.nombre')
            ->where('detalle_servicios.idservicio','=',$id)
            ->orderBy('detalle_servicios.id','desc')->get();

            return ['detalles'=>$detalles];
    }


    public function store(Request $request){
        if(!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();

            $mytime = Carbon::now('America/Monterrey');

            $servicio = new Servicio();
            $servicio->fecha = $mytime->toDateString();
            $servicio->idcliente = $request->idcliente;
            $servicio->idusuario = \Auth::user()->id;
            $servicio->idvehiculo = $request->idvehiculo;
            $servicio->metodopago = $request->metodopago;
            $servicio->horasservicio = $request->horasservicio;
            $servicio->total = $request->total;
            $servicio->fechaservicio = $request->fechaservicio;
            $servicio->impuesto = $request->impuesto;
            $servicio->status = '0';
            $servicio->save();

            $detalles=$request->data;

            foreach ($detalles as $ep => $det) {
                $detalle = new DetalleServicio();
                $detalle->idservicio = $servicio->id;
                $detalle->idinsumo = $det['idinsumo'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precioventa = $det['precioventa'];
                $detalle->descuento = $det['descuento'];
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
        $servicio = Servicio::findOrFail($request->id);
        $servicio->status = '0';
        $servicio->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $servicio = Servicio::findOrFail($request->id);
     
        $servicio->status = '1';
        $servicio->save();
    }
    public function selectServicio(Request $request){
        if(!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $servicios = Servicio::where('id','like','%'.$filtro.'%')
        ->select('id')
        ->orderBy('id','asc')->get();

        return ['servicios'=>$servicios];
    }
    
}
