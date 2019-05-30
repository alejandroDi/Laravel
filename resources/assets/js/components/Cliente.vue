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
                        <i class="fa fa-align-justify"></i> Clientes
                        <button type="button" @click="abrirModal('persona','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="rfc">RFC</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarPersona(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarPersona(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>RFC</th>
                                    <th>Nombre</th>
                                    <th>Direccion</th>
                                    <th>Telefono</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="persona in arrayPersona" :key="persona.id">
                                  
                                    <td>
                                        <button type="button" @click="abrirModal('persona','actualizar',persona)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="persona.status">
                                            <button type="button" class="btn btn-danger btn-sm " @click="desactivarPersona(persona.id)">
                                            <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else="">
                                            <button type="button" class="btn btn-info btn-sm " @click="activarPersona(persona.id)">
                                            <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="persona.rfc"></td>
                                    <td v-text="persona.nombre"></td>
                                    <td v-text="persona.direccion"></td>
                                    <td v-text="persona.telefono"></td>
                                   
                                    
                                    <td>
                                        <div v-if="persona.status">
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
                                    <label class="col-md-3 form-control-label" for="text-input">RFC</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" v-model="rfc" placeholder="Rfc de cliente">
                                        <span>no se aceptan rfc existentes</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" v-model="nombre" placeholder="Nombre de cliente">
                                        <span>no se aceptan nombres existentes</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" v-model="direccion" placeholder="Direccion de cliente">
                                        
                                    </div>
                                </div>
                           
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="number-input">Telefono</label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" v-model="telefono" placeholder="Telefono de cliente">
                                    </div>
                                </div>
                         
                                <div v-show="errorPersona" class="form-group row div-error ">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                                
                                
                            </form>
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
    export default {
        data(){
            return{
                persona_id:0,
                rfc:'',
                nombre:'',
                direccion:'',
                telefono:0,
                arrayPersona:[],
                modal:0,
                tituloModal:'',
                tipoAccion: 0,
                errorPersona: '',
                errorMostrarMsjPersona:[],
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
            listarPersona(page,buscar,criterio){
                let me=this;
                var url='/cliente?page='+ page + '&buscar=' + buscar + '&criterio=' + criterio; 
                axios.get(url).then(function (response) {
                        var respuesta=response.data;
                        me.arrayPersona=respuesta.personas.data;
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
                me.listarPersona(page,buscar,criterio);
            },
            registrarPersona(){
                if(this.validarPersona()){
                    return;
                }
                let me =this;
                axios.post('/cliente/registrar',{
                    'rfc':this.rfc,
                    'nombre':this.nombre,
                    'direccion':this.direccion,
                    'telefono':this.telefono
                }).then(function(response){
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                    
                }).catch(function(error){
                    
                    console.log(error);
                });
            }, 
            actualizarPersona(){
                  if(this.validarPersona()){
                    return;
                }
                let me =this;
                axios.put('/cliente/actualizar',{
                    'id':this.persona_id,
                    'rfc':this.rfc,
                    'nombre':this.nombre,
                    'direccion':this.direccion,
                    'telefono':this.telefono
                }).then(function(response){
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                }).catch(function(error){
                    console.log(error);
                });
            },
            desactivarPersona(id){
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Esta seguro de desactivar este cliente?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/cliente/desactivar',{
                    'id':id
                }).then(function(response){
                    me.listarPersona(1,'','nombre');

                    swalWithBootstrapButtons(
                    'Desactivado!',
                    'El cliente ha sido desactivado con éxito.',
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
             activarPersona(id){
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Esta seguro de activar este cliente?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me =this;

                    axios.put('/cliente/activar',{
                    'id':id
                }).then(function(response){
                    me.listarPersona(1,'','nombre');

                    swalWithBootstrapButtons(
                    'Activado!',
                    'El cliente ha sido activado con éxito.',
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
            validarPersona(){
                this.errorPersona=0;
                this.errorMostrarMsjPersona=[];

              
                
                if(!this.rfc) this.errorMostrarMsjPersona.push("el rfc no debe estar vacio.");
                if(this.rfc.length>13) this.errorMostrarMsjPersona.push("el rfc no debe ser mayor a 13 caracteres");
                if(this.rfc.length<13) this.errorMostrarMsjPersona.push("el rfc no debe ser menor a 13 caracteres");
                if(!this.nombre) this.errorMostrarMsjPersona.push("el nombre no debe estar vacio.");
                if(!this.direccion) this.errorMostrarMsjPersona.push("la direccion no debe estar vacio.");
                if(!this.telefono) this.errorMostrarMsjPersona.push("el telefono no debe estar vacio.");
                if(this.telefono.length>8) this.errorMostrarMsjPersona.push("el numero no debe ser mayor a 8 caracteres");
                if(this.telefono.length<8) this.errorMostrarMsjPersona.push("el numero no debe ser menor a 8 caracteres");
                
                if(this.errorMostrarMsjPersona.length) this.errorPersona=1;
                return this.errorPersona;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.rfc='';
                this.nombre='';
                this.direccion='';
                this.telefono=0;
               

            },
            abrirModal(modelo,accion,data=[]){
                switch(modelo){
                    case "persona":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.tituloModal='Registrar cliente';
                                 this.errorPersona=0;
                                this.modal=1;
                                this.rfc='';
                                this.nombre='';
                                this.direccion='';
                                this.telefono=0;
                               
                                this.tipoAccion=1;
                                break;

                            }
                            case 'actualizar':
                            {
                               // console.log(data);
                               this.errorPersona=0;
                               this.modal=1;
                               this.tituloModal='Actualizar cliente';
                               this.tipoAccion=2;
                               this.persona_id=data['id'];
                               this.rfc=data['rfc'];
                               this.nombre=data['nombre'];
                                this.direccion=data['direccion'];
                                this.telefono=data['telefono'];
                                
                                break;
                            }
                        }
                    }
                }
            }

        },
        mounted() {
            this.listarPersona(1,this.buscar,this.criterio);
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

