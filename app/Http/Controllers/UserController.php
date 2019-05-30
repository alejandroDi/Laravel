<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Persona;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
        
        $buscar = $request->buscar;
        $criterio =$request->criterio;

        if($buscar==''){
            $personas = User::join('personas','users.id','=','personas.id')
            ->join('roles','users.idrol','=','roles.id')
            ->select('personas.id','personas.rfc','personas.nombre','personas.direccion',
            'personas.telefono','personas.status','users.usuario','users.password','users.idrol','roles.nombre as rol')
            ->orderBy('personas.id')->paginate(5); 
        }else{
            $personas = User::join('personas','users.id','=','personas.id')
            ->join('roles','users.idrol','=','roles.id')
            ->select('personas.id','personas.rfc','personas.nombre','personas.direccion',
            'personas.telefono','personas.status','users.usuario','users.password','users.idrol','roles.nombre as rol')
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

            $user = new User();
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);
            $user->idrol = $request->idrol;
            $user->id = $personas->id;
            $user->save();

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

            $user =User::findOrFail($request->id);
            $personas = Persona::findOrFail($user->id);

           
            $personas->rfc = $request->rfc;
            $personas->nombre = $request->nombre;
            $personas->direccion = $request->direccion;
            $personas->telefono = $request->telefono;
            $personas->status = '1';
            $personas->save();

            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);
            $user->idrol = $request->idrol;
          
            $user->save();

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
