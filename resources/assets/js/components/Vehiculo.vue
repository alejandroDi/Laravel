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
                        <i class="fa fa-align-justify"></i> Vehiculos
                        <button type="button" @click="abrirModal('vehiculo','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>  
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="placas">Placa</option>
                                      <option value="color">Color</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarVehiculo(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarVehiculo(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Placas</th>
                                    <th>Marca</th>
                                    <th>Kilometraje</th>
                                    <th>Color</th>
                                    <th>Capacidad</th>
                                    <th>Costo de renta</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="vehiculo in arrayVehiculo" :key="vehiculo.id">
                                    <td>
                                        <button type="button" @click="abrirModal('vehiculo','actualizar',vehiculo)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="vehiculo.status">
                                            <button type="button" class="btn btn-danger btn-sm " @click="desactivarVehiculo(vehiculo.id)">
                                            <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else="">
                                            <button type="button" class="btn btn-info btn-sm " @click="activarVehiculo(vehiculo.id)">
                                            <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="vehiculo.placas"></td>
                                    <td v-text="vehiculo.marca"></td>
                                    <td v-text="vehiculo.kilometraje"></td>
                                    <td v-text="vehiculo.color"></td>
                                    <td v-text="vehiculo.capacidad"></td>
                                    <td v-text="vehiculo.costorenta"></td>
                                  
                                    
                                    <td>
                                        <div v-if="vehiculo.status">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Placas</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" v-model="placas" placeholder="Placas de vehiculo">
                                        <span>no se aceptan placas existentes</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Marca</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" v-model="marca" placeholder="Marca de vehiculo">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="number-input">Kilometraje</label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" v-model="kilometraje" placeholder="Kilometraje de vehiculo">
                                        
                                    </div>
                                </div>
                           
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Color</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" v-model="color" placeholder="Color de vehiculo">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="number-input">Capacidad</label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" v-model="capacidad" placeholder="Capacidad de personas">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="number-input">Costo</label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" v-model="costorenta" placeholder="Costo de renta por hora">
                                    </div>
                                </div>
                         
                                <div v-show="errorVehiculo" class="form-group row div-error ">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjVehiculo" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                                
                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarVehiculo()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarVehiculo()">Actualizar</button>
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
                vehiculo_id:0,
                placas:'',
                marca:'',
                kilometraje:0,
                color:'',
                capacidad:0,
                costorenta:0, 
                arrayVehiculo:[],
                modal:0,
                tituloModal:'',
                tipoAccion: 0,
                errorVehiculo: '',
                errorMostrarMsjVehiculo:[],
                pagination:{
                    'total':0,
                    'current_page':0,
                    'per_page':0,
                    'last_page':0,
                    'from':0,
                    'to':0,
                },
                offset:3,
                criterio:'placas',
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
            listarVehiculo(page,buscar,criterio){
                let me=this;
                var url='/vehiculo?page='+ page + '&buscar=' + buscar + '&criterio=' + criterio; 
                axios.get(url).then(function (response) {
                        var respuesta=response.data;
                        me.arrayVehiculo=respuesta.vehiculos.data;
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
                me.listarVehiculo(page,buscar,criterio);
            }, 
            registrarVehiculo(){
                if(this.validarVehiculo()){
                    return;
                }
                let me =this;
                axios.post('/vehiculo/registrar',{
                    'placas':this.placas,
                    'marca':this.marca,
                    'kilometraje':this.kilometraje,
                    'color':this.color,
                    'capacidad':this.capacidad,
                    'costorenta':this.costorenta
                }).then(function(response){
                    me.cerrarModal();
                    me.listarVehiculo(1,'','placas');
                    
                }).catch(function(error){
                    
                    console.log(error);
                });
            },
             actualizarVehiculo(){
                  if(this.validarVehiculo()){
                    return;
                }
                let me =this;
                axios.put('vehiculo/actualizar',{
                    'id':this.vehiculo_id,
                    'placas':this.placas,
                    'marca':this.marca,
                    'kilometraje':this.kilometraje,
                    'color':this.color,
                    'capacidad':this.capacidad,
                    'costorenta':this.costorenta
                }).then(function(response){
                    me.cerrarModal();
                    me.listarVehiculo(1,'','placas');
                }).catch(function(error){
                    console.log(error);
                });
            },
            desactivarVehiculo(id){
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Esta seguro de desactivar este vehiculo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/vehiculo/desactivar',{
                    'id':id
                }).then(function(response){
                    me.listarVehiculo(1,'','placas');

                    swalWithBootstrapButtons(
                    'Desactivado!',
                    'El vehiculo ha sido desactivado con éxito.',
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
            activarVehiculo(id){
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Esta seguro de activar este vehiculo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/vehiculo/activar',{
                    'id':id
                }).then(function(response){
                    me.listarVehiculo(1,'','placas');

                    swalWithBootstrapButtons(
                    'Activado!',
                    'El vehiculo ha sido activado con éxito.',
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
            validarVehiculo(){
                this.errorVehiculo=0;
                this.errorMostrarMsjVehiculo=[];

              
                
                if(!this.placas) this.errorMostrarMsjVehiculo.push("las placas no debe estar vacio.");
                if(this.placas.length>7) this.errorMostrarMsjVehiculo.push("las placas no debe ser mayor a 7 caracteres");
                if(this.placas.length<7) this.errorMostrarMsjVehiculo.push("las placas no debe ser menor a 7 caracteres");
                if(!this.marca) this.errorMostrarMsjVehiculo.push("la marca no debe estar vacia.");
                if(this.kilometraje<=0) this.errorMostrarMsjVehiculo.push("la kilometraje no debe ser menor o igual a cero.");
                if(!this.color) this.errorMostrarMsjVehiculo.push("el color no debe estar vacio.");
                if(this.capacidad<=0) this.errorMostrarMsjVehiculo.push("la capacida no debe ser menor o igual a cero.");
                if(this.capacidad>5) this.errorMostrarMsjVehiculo.push("sobre pasas la cantidad de 5 personas.");
                if(this.costorenta<=0) this.errorMostrarMsjVehiculo.push("el costo de renta no debe ser menor o igual a cero");
                
                if(this.errorMostrarMsjVehiculo.length) this.errorVehiculo=1;
                return this.errorVehiculo;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.placas='';
                this.marca='';
                this.kilometraje=0;
                this.color='';
                this.capacidad=0;
                this.costorenta=0; 
               

            },
            abrirModal(modelo,accion,data=[]){
                switch(modelo){
                    case "vehiculo":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.tituloModal='Registrar Vhiculo';
                                this.errorVehiculo=0;
                                this.modal=1;
                                this.placas='';
                                this.marca='';
                                this.kilometraje=0;
                                this.color='';
                                this.capacidad=0;
                                this.costorenta=0;
                               
                                this.tipoAccion=1;
                                break;

                            }
                            case 'actualizar':
                            {
                               // console.log(data);
                               this.errorVehiculo=0;
                               this.modal=1;
                               this.tituloModal='Actualizar vehiculo';
                               this.tipoAccion=2;
                               this.vehiculo_id=data['id'];
                               this.placas=data['placas'];
                               this.marca=data['marca'];
                                this.kilometraje=data['kilometraje'];
                                this.color=data['color'];
                                this.capacidad=data['capacidad'];
                                this.costorenta=data['costorenta'];
                                
                                break;
                            }
                        }
                    }
                }
            }

        },
        mounted() {
            this.listarVehiculo(1,this.buscar,this.criterio);
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

