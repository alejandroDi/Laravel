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
                        <i class="fa fa-align-justify"></i> Mantenimientos
                       
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
                                        <th>Vehiculo</th>
                                        <th>Kilometraje</th>
                                        <th>Usuario</th>
                                        <th>Falla</th>
                                        <th>Diagnostico</th>
                                        <th>Observaciones</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="mantenimiento in arrayMantenimiento" :key="mantenimiento.id">
                                        <td>
                                            <button type="button" @click="verMantenimiento(mantenimiento.id)" class="btn btn-success btn-sm">
                                            <i class="icon-eye"></i>
                                            </button> &nbsp;
                                        <template v-if="mantenimiento.status">
                                            <button type="button" class="btn btn-danger btn-sm " @click="desactivarMantenimiento(mantenimiento.id)">
                                            <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else="">
                                            <button type="button" class="btn btn-info btn-sm " @click="activarMantenimiento(mantenimiento.id)">
                                            <i class="icon-check"></i>
                                            </button>
                                        </template>
                                             
                                        </td>
                                        <td v-text="mantenimiento.fecha"></td>
                                        <td v-text="mantenimiento.placas"></td>
                                        <td v-text="mantenimiento.kilometraje"></td>
                                        <td v-text="mantenimiento.usuario"></td>
                                        <td v-text="mantenimiento.falla"></td>
                                        <td v-text="mantenimiento.diagnostico"></td>
                                        <td v-text="mantenimiento.observaciones"></td>
                                       <td>
                                            <div v-if="mantenimiento.status">
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
                             <div class="col-md-4">
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
                             <div class="col-md-3">
                                <label for="">Kilometraje</label>
                                <input type="number" value="0" class="form-control" v-model="kilometraje" v-text="kilometraje" disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="">Diagnostico<span style="color:red;" v-show="diagnostico==''">(*Ingrese)</span></label>
                                <input type="text" class="form-control" v-model="diagnostico">
                            </div>
                             <div class="col-md-2">
                                <div class="form-group">
                                    <label>Falla<span style="color:red;" v-show="falla==''">(*Ingrese)</span></label>
                                    <input type="text"  class="form-control" v-model="falla">
                                </div>
                            </div>
                             <div class="col-md-2">
                                <div class="form-group">
                                    <label>Observaciones<span style="color:red;" v-show="observaciones==''">(*Ingrese)</span></label>
                                    <input type="text" class="form-control" v-model="observaciones">
                                </div>
                            </div>
                           
                            <div class="col-md-12">
                                <div v-show="errorMantenimiento" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjMantenimiento" :key="error" v-text="error">

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
                                    <label>Cantidad <span style="color:red;" v-show="cantidad==0">(*Ingrese)</span></label>
                                    <input type="number" value="0" class="form-control" v-model="cantidad">
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
                                            <th>Cantidad</th>
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
                                                <span style="color:red;" v-show="detalle.cantidad>detalle.existencia">Existencia: {{detalle.existencia}}</span>
                                                <input v-model="detalle.cantidad" type="number" class="form-control">
                                            </td>
                                            
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
                                <button type="button" class="btn btn-primary" @click="registrarMantenimiento()">Registrar Mantenimiento</button>
                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- Fin Detalle-->
                    <!-- Ver ingreso -->
                    <template v-else-if="listado==2">
                    <div class="card-body">
                        <div class="form-group row border">
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Placas</label>
                                    <p v-text="vehiculo"></p>
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kilometraje</label>
                                    <p v-text="kilometraje"></p>
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Falla</label>
                                    <p v-text="falla"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Diagnostico</label>
                                    <p v-text="diagnostico"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <p v-text="observaciones"></p>
                                </div>
                            </div>
                           
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Artículo</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                            <td v-text="detalle.nombre">
                                            </td>
                                            <td v-text="detalle.cantidad">
                                            </td>
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
                idvehiculo:0,
                idusuario:0,
                vehiculo:'',
                diagnostico:'',
                falla:'',
                observaciones:'',
                arrayMantenimiento : [],
                arrayVehiculo:[],
                arrayDetalle : [],
                listado:1,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorMantenimiento : 0,
                errorMostrarMsjMantenimiento : [],
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
                kilometraje:0,
                insumo: '',
                cantidad:0,
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
            }           
        },
        methods : {
            listarMantenimiento (page,buscar,criterio){
                let me=this;
                var url= '/mantenimiento?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayMantenimiento = respuesta.mantenimientos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
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
                me.kilometraje = val1.kilometraje;
            },
            buscarInsumo(){
                let me=this;
                var url= '/insumos/buscarInsumoMantenimiento?filtro=' + me.nombre;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayInsumo = respuesta.insumos;

                    if (me.arrayInsumo.length>0){
                        me.insumo=me.arrayInsumo[0]['nombre'];
                        me.idinsumo=me.arrayInsumo[0]['id'];
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
                me.listarMantenimiento(page,buscar,criterio);
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
                                existencia:me.existencia
                            });
                            me.nombre="";
                            me.idinsumo=0;
                            me.insumo="";
                            me.cantidad=0;
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
            registrarMantenimiento(){
                if (this.validarMantenimiento()){
                    return;
                }
                
                let me = this;

                axios.post('/mantenimiento/registrar',{
                    'idvehiculo': this.idvehiculo,
                     'falla': this.falla,
                    'diagnostico' : this.diagnostico,
                    'observaciones' : this.observaciones,
                    
                    'data': this.arrayDetalle

                }).then(function (response) {
                    me.listado=1;
                    me.listarMantenimiento(1,'','id');
                    me.idinsumo=0;
                    me.insumo='';
                    me.cantidad=0;
                    me.existencia=0;
                    me.arrayDetalle=[];

                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarMantenimiento(){
                let me=this;
                me.errorMantenimiento=0;
                me.errorMostrarMsjMantenimiento =[];
                var ins;

                me.arrayDetalle.map(function(x){
                    if(x.cantidad>x.existencia){
                        ins=x.insumo+" con existencia insuficiente"
                        me.errorMostrarMsjMantenimiento.push(ins);
                    }
                });
                 if (me.idvehiculo==0) me.errorMostrarMsjMantenimiento.push("Seleccione un Vehiculo");
                 if (!me.falla) me.errorMostrarMsjMantenimiento.push("Inserte la falla");
                 if (!me.diagnostico) me.errorMostrarMsjMantenimiento.push("Inserte el diagnostico");
                 if (!me.observaciones) me.errorMostrarMsjMantenimiento.push("Inserte las observaciones");
                if (me.arrayDetalle.length<=0) me.errorMostrarMsjMantenimiento.push("Ingrese detalles");

                if (me.errorMostrarMsjMantenimiento.length) me.errorMantenimiento = 1;

                return me.errorMantenimiento;
            },
            mostrarDetalle(){
                let me=this;
                me.listado=0;
                me.idvehiculo=0;
                me.idinsumo=0;
                me.insumo='';
                me.cantidad=0;
                me.arrayDetalle=[];
            },
            ocultarDetalle(){
                this.listado=1;
            },
            verMantenimiento(id){
                let me=this;
                me.listado=2;
                
                //Obtener los datos del ingreso
                var arrayMantenimientoT=[];
                var url= '/mantenimiento/obtenerCabecera?id=' + id;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayMantenimientoT = respuesta.mantenimiento;

                    me.cliente = arrayMantenimientoT[0]['nombre'];
                    me.vehiculo=arrayMantenimientoT[0]['placas'];
                    me.kilometraje=arrayMantenimientoT[0]['kilometraje'];
                    me.falla=arrayMantenimientoT[0]['falla'];
                    me.diagnostico=arrayMantenimientoT[0]['diagnostico'];
                    me.observaciones=arrayMantenimientoT[0]['observaciones'];
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos de los detalles 
                var urld= '/mantenimiento/obtenerDetalles?id=' + id;
                
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
            desactivarMantenimiento(id){
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Esta seguro de desactivar este Mantenimiento?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/mantenimiento/desactivar',{
                    'id':id
                }).then(function(response){
                    me.listarMantenimiento(1,'','id');

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
             activarMantenimiento(id){
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Esta seguro de activar este Mantenimiento?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/mantenimiento/activar',{
                    'id':id
                }).then(function(response){
                    me.listarMantenimiento(1,'','id');

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
            this.listarMantenimiento(1,this.buscar,this.criterio);
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
