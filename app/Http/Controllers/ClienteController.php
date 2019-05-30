<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        
        $buscar = $request->buscar;
        $criterio =$request->criterio;

        if($buscar==''){
            $personas = Persona::orderBy('id','desc')->paginate(5);
        }else{
            $personas = Persona::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(5);
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
        $personas = new Persona();
        $personas->rfc = $request->rfc;
        $personas->nombre = $request->nombre;
        $personas->direccion = $request->direccion;
        $personas->telefono = $request->telefono;
        $personas->status = '1';
        $personas->save();

    }
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $personas = Persona::findOrFail($request->id);
        $personas->rfc = $request->rfc;
        $personas->nombre = $request->nombre;
        $personas->direccion = $request->direccion;
        $personas->telefono = $request->telefono;
        $personas->status = '1';
        $personas->save();
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

    public function selectCliente(Request $request){
        if(!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $clientes = Persona::where('nombre','like','%'.$filtro.'%')
        ->orWhere('rfc','like','%'.$filtro.'%')
        ->select('id','nombre','rfc')
        ->orderBy('nombre','asc')->get();

        return ['clientes'=>$clientes];
    }
}
