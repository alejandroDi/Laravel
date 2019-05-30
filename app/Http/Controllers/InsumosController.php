<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Insumos;
class InsumosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        
        $buscar = $request->buscar;
        $criterio =$request->criterio;

        if($buscar==''){
            $insumos = Insumos::orderBy('id','desc')->paginate(5);
        }else{
            $insumos = Insumos::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(5);
        }

        

        return [
            'pagination'=>[
                'total'       =>$insumos->total(),
                'current_page'=>$insumos->currentPage(),
                'per_page'    =>$insumos->perPage(),
                'last_page'   =>$insumos->lastPage(),
                'from'        =>$insumos->firstItem(),
                'to'          =>$insumos->lastItem(),
            ],
            'insumos'=>$insumos
        ];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if(!$request->ajax()) return redirect('/');
        $insumos = new Insumos();
        $insumos->nombre = $request->nombre;
        $insumos->existencia = $request->existencia;
        $insumos->precioventa = $request->precioventa;
        $insumos->preciocompra = $request->preciocompra;
        $insumos->ubicacion = $request->ubicacion;
        $insumos->status = '1';
        $insumos->save();

    }

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $insumos = Insumos::findOrFail($request->id);
        $insumos->nombre = $request->nombre;
        $insumos->existencia = $request->existencia;
        $insumos->precioventa = $request->precioventa;
        $insumos->preciocompra = $request->preciocompra;
        $insumos->ubicacion = $request->ubicacion;
        $insumos->status = '1';
        $insumos->save(); 
    }

    public function listarInsumo(Request $request){
        if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;

        if($buscar==''){
            $insumos = Insumos::orderBy('id','desc')
            ->where('existencia','>','0')
            ->paginate(5);
        }else{
            $insumos = Insumos::where($criterio,'like','%'.$buscar.'%')
            ->where('existencia','>','0')
            ->orderBy('id','desc')->paginate(5);
        }

        return['insumos'=>$insumos];
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $insumos = Insumos::findOrFail($request->id);
     
        $insumos->status = '0';
        $insumos->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $insumos = Insumos::findOrFail($request->id);
     
        $insumos->status = '1';
        $insumos->save();
    }

    public function buscarInsumoServicio(Request $request){
        if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $insumos = Insumos::where('nombre','like','%'.$filtro.'%')
        ->select('id','nombre','existencia','precioventa')
        ->where('existencia','>','0')
        ->orderBy('nombre','asc')
        ->take(1)->get();

        return ['insumos'=>$insumos];
    }

    public function buscarInsumoMantenimiento(Request $request){
        if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $insumos = Insumos::where('nombre','like','%'.$filtro.'%')
        ->select('id','nombre','existencia')
        ->where('existencia','>','0')
        ->orderBy('nombre','asc')
        ->take(1)->get();

        return ['insumos'=>$insumos];
    }

  

}
