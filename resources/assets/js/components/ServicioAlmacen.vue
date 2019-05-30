<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                  <div class="card-header">
                        <i class="fa fa-align-justify"></i> Servicios
                       
                    </div>
                    <!-- Listado-->
                    <template v-if="listado==1">
                    <div class="card-body"> 
                      
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Fecha Hora</th>
                                        <th>Cliente</th>
                                        <th>Usuario</th>
                                        <th>Vehiculo</th>
                                        <th>Costo por hora</th>
                                        <th>Metodo de pago</th>
                                        <th>Horas servicio</th>
                                        <th>Total</th>
                                        <th>Fecha servicio</th>
                                        <th>Impuesto</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="servicio in arrayServicio" :key="servicio.id">
                                        <td>
                                            <button type="button" @click="verServicio(servicio.id)" class="btn btn-success btn-sm">
                                            <i class="icon-eye"></i>
                                            </button> &nbsp;

                                        <template v-if="servicio.status">
                                            <button type="button" class="btn btn-danger btn-sm " @click="desactivarServicio(servicio.id)">
                                            <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else="">
                                            <button type="button" class="btn btn-info btn-sm " @click="activarServicio(servicio.id)">
                                            <i class="icon-check"></i>
                                            </button>
                                        </template>
                                             
                                        </td>
                                        <td v-text="servicio.fecha"></td>
                                        <td v-text="servicio.nombre"></td>
                                        <td v-text="servicio.usuario"></td>
                                        <td v-text="servicio.placas"></td>
                                        <td v-text="servicio.costorenta"></td>
                                        <td v-text="servicio.metodopago"></td>
                                        <td v-text="servicio.horasservicio"></td>
                                        <td v-text="servicio.total"></td>
                                        <td v-text="servicio.fechaservicio"></td>
                                        <td v-text="servicio.impuesto"></td>
                                       <td>
                                            <div v-if="servicio.status">
                                                <span class="badge badge-success">Activo</span>
                                            </div>

                                            <div v-else>
                                                <span class="badge badge-danger">Desactivado</span>
                                            </div>
                                        
                                        </td>
                                        
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    </template>
                    <!--Fin Listado-->
                    <!-- Detalle-->
                    <template v-else-if="listado==0">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="">Cliente(*)</label>
                                    <v-select
                                        :on-search="selectCliente"
                                        label="nombre"
                                        :options="arrayCliente"
                                        placeholder="Buscar Cliente..."
                                        :onChange="getDatosCliente"                                        
                                    >

                                    </v-select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="">Impuesto(*)</label>
                                <input type="text" class="form-control" v-model="impuesto">
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha de servicio<span style="color:red;" v-show="fechaservicio=='YEAR-MONTH-DAY'">(*ingrese)</span></label><br><br>
                                    <date-pick v-model="fechaservicio" :pickTime="false" :Format="'DD.MM.YYYY'"></date-pick>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Metodo de pago<span style="color:red;" v-show="metodopago==0">(*ingrese)</span></label>
                                    <select class="form-control" v-model="metodopago" >
                                        <option value="0">Seleccione</option>
                                        <option value="EFECTIVO">Efectivo</option>
                                        <option value="TARJETA">Tarjeta</option>
                                        
                                    </select>
                                </div>
                            </div>
                             <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Vehiculo</label>
                                    <v-select
                                        :on-search="selectVehiculo"
                                        label="placas"
                                        :options="arrayVehiculo"
                                        placeholder="Buscar Vehiculo..."
                                        :onChange="getDatosVehiculo"                                        
                                    >

                                    </v-select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Horas de servicio <span style="color:red;" v-show="horasservicio==0 || horasservicio<=0">(*Ingrese)</span></label>
                                    <input type="number" value="0" class="form-control" v-model="horasservicio">
                                </div>
                            </div>
                             <div class="col-md-2">
                                <div class="form-group">
                                    <label>Costo por hora <span style="color:red;" v-show="costorenta==0">(*Ingrese)</span></label>
                                    <input type="number" value="0" class="form-control" v-model="costorenta" v-text="costorenta" disabled>
                                </div>
                            </div>
                           
                            <div class="col-md-12">
                                <div v-show="errorServicio" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjServicio" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Insumos <span style="color:red;" v-show="idinsumo==0">(*Seleccione)</span></label>
                                    <div class="form-inline">
                                        <input type="text" class="form-control" v-model="nombre" @keyup.enter="buscarInsumo()" placeholder="Ingrese artículo">
                                        <button @click="abrirModal()" class="btn btn-primary">...</button>
                                        <input type="text" readonly class="form-control" v-model="insumo">
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Precio <span style="color:red;" v-show="precioventa==0"></span></label>
                                    <input type="number" value="0" step="any" class="form-control" v-model="precioventa" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cantidad <span style="color:red;" v-show="cantidad==0">(*Ingrese)</span></label>
                                    <input type="number" value="0" class="form-control" v-model="cantidad">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Descuento</label>
                                    <input type="number" value="0" class="form-control" v-model="descuento">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar"><i class="icon-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Insumo</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Descuento</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                            <td>
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </td>
                                            <td v-text="detalle.insumo">
                                            </td>
                                            <td>
                                                <input v-model="detalle.precioventa" type="number" class="form-control" disabled>
                                            </td>
                                            <td>
                                                <span style="color:red;" v-show="detalle.cantidad>detalle.existencia">Existencia: {{detalle.existencia}}</span>
                                                <input v-model="detalle.cantidad" type="number" class="form-control">
                                            </td>
                                            <td>
                                                <span style="color:red;" v-show="detalle.descuento>(detalle.precioventa*detalle.cantidad)">Descuento superior</span>
                                                <input v-model="detalle.descuento" type="number"  class="form-control">
                                            </td>
                                            <td>
                                                {{detalle.precioventa*detalle.cantidad-detalle.descuento}}
                                            </td>
                                            
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="5" align="right"><strong>Total Parcial:</strong></td>
                                            <td>$ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="5" align="right"><strong>Total Impuesto:</strong></td>
                                            <td>$ {{totalImpuesto=((total*impuesto)/(1+impuesto)).toFixed(2)}}</td>
                                        </tr>
                                         <tr style="background-color: #CEECF5;">
                                            <td colspan="5" align="right"><strong>Total Renta Auto:</strong></td>
                                            <td>$ {{total2=calcularRenta}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="5" align="right"><strong>Total Neto:</strong></td>
                                            <td>$ {{total=calcularTotal+calcularRenta}}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="6">
                                                NO hay artículos agregados
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="registrarServicio()">Registrar Servicio</button>
                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- Fin Detalle-->
                    <!-- Ver ingreso -->
                    <template v-else-if="listado==2">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="">Cliente</label>
                                    <p v-text="cliente"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="">Impuesto</label>
                                <p v-text="impuesto"></p>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Placas</label>
                                    <p v-text="vehiculo"></p>
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Horas de servicio</label>
                                    <p v-text="horasservicio"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Costo por hora</label>
                                    <p v-text="costorenta"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha de servicio</label>
                                    <p v-text="fechaservicio"></p>
                                </div>
                            </div>
                           
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Artículo</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Descuento</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                            <td v-text="detalle.nombre">
                                            </td>
                                            <td v-text="detalle.precioventa">
                                            </td>
                                            <td v-text="detalle.cantidad">
                                            </td>
                                            <td v-text="detalle.descuento">
                                            </td>
                                            <td>
                                                {{detalle.precioventa*detalle.cantidad-detalle.descuento}}
                                            </td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Total Parcial:</strong></td>
                                            <td>$ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Total Impuesto:</strong></td>
                                            <td>$ {{totalImpuesto=((total*impuesto)).toFixed(2)}}</td>
                                        </tr>
                                         <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Total Renta Auto:</strong></td>
                                            <td>$ {{calcularRenta}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Total Neto:</strong></td>
                                            <td>$ {{total}}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                                NO hay artículos agregados
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                
                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- fin ver ingreso -->
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterioA">
                                        <option value="nombre">Nombre</option>
                                        </select>
                                        <input type="text" v-model="buscarA" @keyup.enter="listarInsumo(buscarA,criterioA)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarInsumo(buscarA,criterioA)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Nombre</th>
                                            <th>Existencia</th>
                                            <th>Ubicacion</th>
                                            <th>Precio venta</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="insumo in arrayInsumo" :key="insumo.id">
                                            <td>
                                                <button type="button" @click="agregarDetalleModal(insumo)" class="btn btn-success btn-sm">
                                                <i class="icon-check"></i>
                                                </button>
                                            </td>
                                            <td v-text="insumo.nombre"></td>
                                            <td v-text="insumo.existencia"></td>
                                            <td v-text="insumo.ubicacion"></td>
                                            <td v-text="insumo.precioventa  "></td>
                                            
                                            <td>
                                                <div v-if="insumo.status">
                                                    <span class="badge badge-success">Activo</span>
                                                </div>
                                                <div v-else>
                                                    <span class="badge badge-danger">Desactivado</span>
                                                </div>
                                                
                                            </td>
                                        </tr>                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    import vSelect from 'vue-select';
    import DatePick from 'vue-date-pick';
    import 'vue-date-pick/dist/vueDatePick.css';
    export default {
        data (){
            return {
                venta_id: 0,
                idcliente:0,
                idvehiculo:0,
                idusuario:0,
                fechaservicio:'YEAR-MONTH-DAY',
                cliente:'',
                vehiculo:'',
                metodopago : '',
                horasservicio : 0,
                costorenta:0,
                impuesto: 0.18,
                total:0.0,
                total2:0.0,
                totalImpuesto: 0.0,
                totalrentaauto:0.0,
                totalParcial: 0.0,
                arrayServicio : [],
                arrayCliente: [],
                arrayVehiculo:[],
                arrayDetalle : [],
                listado:1,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorServicio : 0,
                errorMostrarMsjServicio : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : '',
                criterioA:'nombre',
                buscarA: '',
                arrayInsumo: [],
                idinsumo: 0,
                nombre: '',
                insumo: '',
                precioventa: 0,
                cantidad:0,
                descuento:0,
                existencia:0
            }
        },
        components: {
            vSelect,
            DatePick
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
            calcularTotal: function(){
                var resultado=0.0;
               
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado=resultado+(this.arrayDetalle[i].precioventa*this.arrayDetalle[i].cantidad-this.arrayDetalle[i].descuento)
                }
                

                return resultado;
            },
             calcularRenta: function(){
                var resultado=0.0;
               
               resultado=this.costorenta*this.horasservicio
                

                return resultado;
            }

            
        },
        methods : {
            listarServicio (page,buscar,criterio){
                let me=this;
                var url= '/servicio?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayServicio = respuesta.servicios.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectCliente(search,loading){
                let me=this;
                loading(true)

                var url= '/cliente/selectCliente?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayCliente=respuesta.clientes;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosCliente(val1){
                let me = this;
                me.loading = true;
                me.idcliente = val1.id;
            },
             selectVehiculo(search,loading){
                let me=this;
                loading(true)

                var url= '/vehiculo/selectVehicu?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayVehiculo=respuesta.vehiculos;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosVehiculo(val1){
                let me = this;
                me.loading = true;
                me.idvehiculo = val1.id;
                me.costorenta=val1.costorenta;
            },
            buscarInsumo(){
                let me=this;
                var url= '/insumos/buscarInsumoServicio?filtro=' + me.nombre;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayInsumo = respuesta.insumos;

                    if (me.arrayInsumo.length>0){
                        me.insumo=me.arrayInsumo[0]['nombre'];
                        me.idinsumo=me.arrayInsumo[0]['id'];
                        me.precioventa=me.arrayInsumo[0]['precioventa'];
                        me.existencia=me.arrayInsumo[0]['existencia'];
                    }
                    else{
                        me.insumo='No existe artículo';
                        me.idinsumo=0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarServicio(page,buscar,criterio);
            },
            encuentra(id){
                var sw=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].idinsumo==id){
                        sw=true;
                    }
                }
                return sw;
            },
            eliminarDetalle(index){
                let me = this;
                me.arrayDetalle.splice(index, 1);
            },
            agregarDetalle(){
                let me=this;
                if(me.idinsumo==0 || me.cantidad==0 || me.precioventa==0){
                }
                else{
                    if(me.encuentra(me.idinsumo)){
                        swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'Ese artículo ya se encuentra agregado!',
                            })
                    }
                    else{
                        if(me.cantidad > me.existencia){
                             swal({
                                type: 'error',
                                title: 'Error...',
                                text: 'Este articulo sobrepasa la cantidad!',
                                })
                        }else{
                              me.arrayDetalle.push({
                                idinsumo: me.idinsumo,
                                insumo: me.insumo,
                                cantidad: me.cantidad,
                                precioventa: me.precioventa,
                                descuento:me.descuento,
                                existencia:me.existencia
                            });
                            me.nombre="";
                            me.idinsumo=0;
                            me.insumo="";
                            me.cantidad=0;
                            me.precioventa=0; 
                            me.descuento=0;
                            me.existencia=0;

                        }
                    }
                    
                }

                

            },
            agregarDetalleModal(data =[]){
                let me=this;
                if(me.encuentra(data['id'])){
                        swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'Ese artículo ya se encuentra agregado!',
                            })
                    }
                    else{
                       me.arrayDetalle.push({
                            idinsumo: data['id'],
                            insumo: data['nombre'],
                            cantidad: 1,
                            precioventa: data['precioventa'],
                            descuento: 0,
                            existencia:data['existencia']
                        }); 
                    }
            },
            listarInsumo (buscar,criterio){
                let me=this;
                var url= '/insumos/listarInsumo?buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayInsumo = respuesta.insumos.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarServicio(){
                if (this.validarServicio()){
                    return;
                }
                
                let me = this;

                axios.post('/servicio/registrar',{
                    'idcliente': this.idcliente,
                    'idvehiculo': this.idvehiculo,
                     'metodopago': this.metodopago,
                    'horasservicio' : this.horasservicio,
                    'total' : this.total,
                    'fechaservicio' : this.fechaservicio,
                    'impuesto' : this.impuesto,
                    
                    'data': this.arrayDetalle

                }).then(function (response) {
                    me.listado=1;
                    me.listarServicio(1,'','id');
                    me.idcliente=0;
                    me.horasservicio=0;
                    me.fechaservicio='YEAR-MONTH-DAY';
                    me.impuesto=0.18;
                    me.total=0.0;
                    me.idinsumo=0;
                    me.insumo='';
                    me.cantidad=0;
                    me.precioventa=0;
                    me.existencia=0;
                    me.descuento=0;
                    me.arrayDetalle=[];

                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarServicio(){
                let me=this;
                me.errorServicio=0;
                me.errorMostrarMsjServicio =[];
                var ins;

                me.arrayDetalle.map(function(x){
                    if(x.cantidad>x.existencia){
                        ins=x.insumo+" con existencia insuficiente"
                        me.errorMostrarMsjServicio.push(ins);
                    }
                });

                if (!me.fechaservicio) me.errorMostrarMsjServicio.push("Seleccione una fecha");
                if (me.idcliente==0) me.errorMostrarMsjServicio.push("Seleccione un Cliente");
                 if (me.idvehiculo==0) me.errorMostrarMsjServicio.push("Seleccione un Vehiculo");
                if (me.metodopago==0) me.errorMostrarMsjServicio.push("Seleccione metodo de pago");
                if (!me.impuesto) me.errorMostrarMsjServicio.push("Ingrese el impuesto de compra");
                if (me.arrayDetalle.length<=0) me.errorMostrarMsjServicio.push("Ingrese detalles");

                if (me.errorMostrarMsjServicio.length) me.errorServicio = 1;

                return me.errorServicio;
            },
            mostrarDetalle(){
                let me=this;
                me.listado=0;

                me.idcliente=0;
                me.idvehiculo=0;
                me.fechaservicio='YEAR-MONTH-DAY';
                me.metodopago='';
                me.horasservicio=0;
                me.impuesto=0.18;
                me.total=0.0;
                me.idinsumo=0;
                me.insumo='';
                me.cantidad=0;
                me.precioventa=0;
                me.arrayDetalle=[];
            },
            ocultarDetalle(){
                this.listado=1;
            },
            verServicio(id){
                let me=this;
                me.listado=2;
                
                //Obtener los datos del ingreso
                var arrayServicioT=[];
                var url= '/servicio/obtenerCabecera?id=' + id;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayServicioT = respuesta.servicio;

                    me.cliente = arrayServicioT[0]['nombre'];
                    me.vehiculo=arrayServicioT[0]['placas'];
                    me.metodopago=arrayServicioT[0]['metodopago'];
                    me.costorenta=arrayServicioT[0]['costorenta'];
                    me.horasservicio=arrayServicioT[0]['horasservicio'];
                    me.fechaservicio=arrayServicioT[0]['fechaservicio'];
                    me.impuesto=arrayServicioT[0]['impuesto'];
                    me.total=arrayServicioT[0]['total'];
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos de los detalles 
                var urld= '/servicio/obtenerDetalles?id=' + id;
                
                axios.get(urld).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.detalles;
                })
                .catch(function (error) {
                    console.log(error);
                });               
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
            }, 
            abrirModal(){               
                this.arrayInsumo=[];
                this.modal = 1;
                this.tituloModal = 'Seleccione uno o varios artículos';
            },
             desactivarServicio(id){
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Esta seguro de desactivar este servicio?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/servicio/desactivar',{
                    'id':id
                }).then(function(response){
                    me.listarServicio(1,'','id');

                    swalWithBootstrapButtons(
                    'Desactivado!',
                    'El registro ha sido desactivado con éxito.',
                    'success'
                    )
                }).catch(function(error){
                    console.log(error);
                });
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                })
            },
             activarServicio(id){
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Esta seguro de activar este servicio?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/servicio/activar',{
                    'id':id
                }).then(function(response){
                    me.listarServicio(1,'','id');

                    swalWithBootstrapButtons(
                    'Activado!',
                    'El registro ha sido activado con éxito.',
                    'success'
                    )
                }).catch(function(error){
                    console.log(error);
                });
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                })
            },
           
        },
        mounted() {
            this.listarServicio(1,this.buscar,this.criterio);
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }

</style>
