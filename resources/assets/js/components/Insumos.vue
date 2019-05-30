<template>
    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Insumos
                        <button type="button" @click="abrirModal('insumos','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="id">Id</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarInsumos(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarInsumos(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Existencia</th>
                                    <th>Precio venta</th>
                                    <th>Precio compra</th>
                                    <th>Ubicacion</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="insumos in arrayInsumos" :key="insumos.id">
                                  
                                    <td>
                                        <button type="button" @click="abrirModal('insumos','actualizar',insumos)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="insumos.status">
                                            <button type="button" class="btn btn-danger btn-sm " @click="desactivarInsumo(insumos.id)">
                                            <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else="">
                                            <button type="button" class="btn btn-info btn-sm " @click="activarInsumo(insumos.id)">
                                            <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="insumos.nombre"></td>
                                    <td v-text="insumos.existencia"></td>
                                    <td v-text="insumos.precioventa"></td>
                                    <td v-text="insumos.preciocompra"></td>
                                    <td v-text="insumos.ubicacion"></td>
                                    
                                    <td>
                                        <div v-if="insumos.status">
                                            <span class="badge badge-success">Activo</span>
                                        </div>

                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1 , buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" data-dismiss="modal" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" v-model="nombre" placeholder="Nombre de insumo">
                                        <span>no se aceptan nombre repetidos</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="number-input">Existencia</label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" v-model="existencia" placeholder="Enter Existencia">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="number-input">Precio venta</label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" v-model="precioventa" placeholder="Enter precio">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="number-input">Precio compra</label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" v-model="preciocompra" placeholder="Enter precio">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Ubicacion</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" v-model="ubicacion" placeholder="Enter Ubicacion">
                                    </div>
                                </div>
                                <div v-show="errorInsumos" class="form-group row div-error ">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjInsumos" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                                
                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarInsumos()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarInsumos()">Actualizar</button>
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
    export default {
        data(){
            return{
                insumo_id:0,
                nombre:'',
                existencia:0,
                precioventa:0,
                preciocompra:0,
                ubicacion:'',
                arrayInsumos:[],
                modal:0,
                tituloModal:'',
                tipoAccion: 0,
                errorInsumos: '',
                errorMostrarMsjInsumos:[],
                pagination:{
                    'total':0,
                    'current_page':0,
                    'per_page':0,
                    'last_page':0,
                    'from':0,
                    'to':0,
                },
                offset:3,
                criterio:'nombre',
                buscar:''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            pagesNumber: function(){
                if(!this.pagination.to){
                    return [];
                }
                  
                var from=this.pagination.current_page - this.offset;
                if(from<1){
                    from=1;
                }

                var to = from + (this.offset*2);
                if(to>=this.pagination.last_page){
                    to=this.pagination.last_page;
                }

                var pagesArray =[];
                while(from<=to){
                    pagesArray.push(from);
                    from ++;
                }
                return pagesArray;
            }        
        },
        methods : {
            listarInsumos(page,buscar,criterio){
                let me=this;
                var url='/insumos?page='+ page + '&buscar=' + buscar + '&criterio=' + criterio; 
                axios.get(url).then(function (response) {
                        var respuesta=response.data;
                        me.arrayInsumos=respuesta.insumos.data;
                        me.pagination=respuesta.pagination;
                    })
                    .catch(function (error) {
                    
                        console.log(error);
                    });
            },
            cambiarPagina(page,buscar,criterio){
                let me =this;
                //actualiza pagina actual
                me.pagination.current_page=page;
                //envia peticion para visualizar la data de esa pagina
                me.listarInsumos(page,buscar,criterio);
            },
            registrarInsumos(){
                if(this.validarInsumos()){
                    return;
                }
                let me =this;
                axios.post('/insumos/registrar',{
                    'nombre':this.nombre,
                    'existencia':this.existencia,
                    'precioventa':this.precioventa,
                    'preciocompra':this.preciocompra,
                    'ubicacion':this.ubicacion
                }).then(function(response){
                    me.cerrarModal();
                    me.listarInsumos(1,'','nombre');
                    
                }).catch(function(error){
                    
                    console.log(error);
                });
            },
            actualizarInsumos(){
                  if(this.validarInsumos()){
                    return;
                }
                let me =this;
                axios.put('/insumos/actualizar',{
                    'id':this.insumo_id,
                    'nombre':this.nombre,
                    'existencia':this.existencia,
                    'precioventa':this.precioventa,
                    'preciocompra':this.preciocompra,
                    'ubicacion':this.ubicacion
                }).then(function(response){
                    me.cerrarModal();
                    me.listarInsumos(1,'','nombre');
                }).catch(function(error){
                    console.log(error);
                });
            },
            desactivarInsumo(id){
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Esta seguro de desactivar este insumo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/insumos/desactivar',{
                    'id':id
                }).then(function(response){
                    me.listarInsumos(1,'','nombre');

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
             activarInsumo(id){
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Esta seguro de activar este insumo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/insumos/activar',{
                    'id':id
                }).then(function(response){
                    me.listarInsumos(1,'','nombre');

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
            validarInsumos(){
                this.errorInsumos=0;
                this.errorMostrarMsjInsumos=[];

              
                
                if(!this.nombre) this.errorMostrarMsjInsumos.push("el nombre de insumos no puede estar vacio.");
                if(this.existencia<=0) this.errorMostrarMsjInsumos.push("La existencia debe ser mayor a 0.");
                if(this.precioventa<=0) this.errorMostrarMsjInsumos.push("El precio de venta debe ser mayor a 0.");
                if(this.preciocompra<=0) this.errorMostrarMsjInsumos.push("El precio de compra debe ser menor a 0.");
                if(!this.ubicacion) this.errorMostrarMsjInsumos.push("La ubicacion no puede estar vacia.");
                if(this.errorMostrarMsjInsumos.length) this.errorInsumos=1;
                return this.errorInsumos;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.existencia=0;
                this.precioventa=0;
                this.preciocompra=0;
                this.ubicacion='';

            },
            abrirModal(modelo,accion,data=[]){
                switch(modelo){
                    case "insumos":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.tituloModal='Registrar insumo';
                                 this.errorInsumos=0;
                                this.modal=1;
                                this.nombre='';
                                this.existencia=0;
                                this.precioventa=0;
                                this.preciocompra=0;
                                this.ubicacion='';
                                this.tipoAccion=1;
                                break;

                            }
                            case 'actualizar':
                            {
                               // console.log(data);
                               this.errorInsumos=0;
                               this.modal=1;
                               this.tituloModal='Actualizar insumo';
                               this.tipoAccion=2;
                               this.insumo_id=data['id'];
                               this.nombre=data['nombre'];
                                this.existencia=data['existencia'];
                                this.precioventa=data['precioventa'];
                                this.preciocompra=data['preciocompra'];
                                this.ubicacion=data['ubicacion'];
                                break;
                            }
                        }
                    }
                }
            }

        },
        mounted() {
            this.listarInsumos(1,this.buscar,this.criterio);
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
        justify-content: center;
        justify-content: center;
    }
    .text-error{
        color: red;
        font-weight: bold;
    }
</style>

