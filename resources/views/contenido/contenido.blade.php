@extends('principal')
@section('contenido')

 @if(Auth::check())
            @if(Auth::user()->idrol==1)
                <template v-if="menu==0">
                        <h1>escritorio</h1>
                </template>
                <template v-if="menu==1">
                        <Insumos></Insumos>
                </template>
                <template v-if="menu==2">
                        <servicioalmacen></servicioalmacen>
                </template>
                <template v-if="menu==12">
                        <mantenimientoalmacen></mantenimientoalmacen>
                </template>
                <template v-if="menu==3">
                        <devolucionalmacen></devolucionalmacen> 
                </template>
                <template v-if="menu==4">
                        <devolucion></devolucion>  
                </template>
                <template v-if="menu==5">
                        <servicio></servicio>
                </template>
                <template v-if="menu==6">
                        <cliente></cliente>
                </template>
                <template v-if="menu==7">
                        <mantenimiento></mantenimiento>
                </template>
                <template v-if="menu==8">
                        <user></user>    
                </template>
                <template v-if="menu==9">
                        <chofer></chofer>  
                </template>
                <template v-if="menu==10">
                        <vehiculo></vehiculo> 
                </template>
                <template v-if="menu==11">
                        <rol></rol>  
                </template>
            @elseif(Auth::user()->idrol==2)
                <template v-if="menu==1">
                        <Insumos></Insumos>
                </template>
                <template v-if="menu==2">
                        <servicioalmacen></servicioalmacen>
                </template>
                <template v-if="menu==12">
                        <mantenimientoalmacen></mantenimientoalmacen> 
                </template>
                <template v-if="menu==3">
                        <h1>devolucionalm</h1> 
                </template>
            @elseif(Auth::user()->idrol==3)
                <template v-if="menu==5">
                        <servicio></servicio>
                </template>
                <template v-if="menu==6">
                        <cliente></cliente>
                </template>
            @elseif(Auth::user()->idrol==4)
                <template v-if="menu==4">
                         <devolucion></devolucion>  
                </template>
            @elseif(Auth::user()->idrol==5)
                <template v-if="menu==7">
                         <mantenimiento></mantenimiento>
                </template>  
            @else
            @endif
@endif


<!-- /Fin del contenido principal -->
        @endsection('contenido')