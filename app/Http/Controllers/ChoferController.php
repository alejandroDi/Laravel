<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chofer;
use App\Persona;
use Illuminate\Support\Facades\DB;

class ChoferController extends Controller
{
    public function index(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
        
        $buscar = $request->buscar;
        $criterio =$request->criterio;

        if($buscar==''){
            $personas = Chofer::join('personas','chofers.id','=','personas.id')
            ->join('vehiculos','chofers.idvehiculo','=','vehiculos.id')
            ->select('personas.id','personas.rfc','personas.nombre','personas.direccion',
            'personas.telefono','personas.status','chofers.idvehiculo','vehiculos.placas')
            ->orderBy('personas.id')->paginate(5);
        }else{
            $personas = Chofer::join('personas','chofers.id','=','personas.id')
            ->join('vehiculos','chofers.idvehiculo','=','vehiculos.id')
            ->select('personas.id','personas.rfc','personas.nombre','personas.direccion',
            'personas.telefono','personas.status','chofers.idvehiculo','vehiculos.placas')
            ->where('personas.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('id','desc')->paginate(5);
        }

        

        return [
            'pagination'=>[
                'total'       =>$personas->total(),
                'current_page'=>$personas->currentPage(),
                'per_page'    =>$personas->perPage(),
                'last_page'   =>$personas->lastPage(),
                'from'        =>$personas->firstItem(),
                'to'          =>$personas->lastItem(),
            ],
            'personas'=>$personas
        ];
    }
    public function store(Request $request)
    {
        
        if(!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();
            $personas = new Persona();
            $personas->rfc = $request->rfc;
            $personas->nombre = $request->nombre;
            $personas->direccion = $request->direccion;
            $personas->telefono = $request->telefono;
            $personas->status = '1';
            $personas->save();

            $chofers = new Chofer();
            $chofers->idvehiculo = $request->idvehiculo;
            $chofers->id = $personas->id;
            $chofers->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
        

    }
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();

            $chofers =Chofer::findOrFail($request->id);
            $personas = Persona::findOrFail($chofers->id);

           
            $personas->rfc = $request->rfc;
            $personas->nombre = $request->nombre;
            $personas->direccion = $request->direccion;
            $personas->telefono = $request->telefono;
            $personas->status = '1';
            $personas->save();

            
            $chofers->idvehiculo = $request->idvehiculo;
            $chofers->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    } 

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $personas = Persona::findOrFail($request->id);
        $personas->status = '0';
        $personas->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $personas = Persona::findOrFail($request->id);
        $personas->status = '1';
        $personas->save();
    }
}
