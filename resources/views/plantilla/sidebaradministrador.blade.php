<div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li @click="menu=0" class="nav-item">
                        <a class="nav-link active" href="#"><i class="icon-speedometer"></i> Escritorio</a>
                    </li>
                    <li class="nav-title">
                        Menu principal
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i> Almacén</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=1" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-plus"></i>Insumos</a>
                            </li>
                            <li class="nav-item" @click="menu=2">
                                <a class="nav-link" href="#"><i class="icon-arrow-left"></i> Pedidos</a>
                            </li>
                            <li class="nav-item" @click="menu=12">
                                <a class="nav-link" href="#"><i class="icon-arrow-left"></i> Taller</a>
                            </li>
                            <li class="nav-item" @click="menu=3">
                                <a class="nav-link" href="#"><i class="icon-arrow-right"></i> Devoluciones</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-eye"></i> Vigilancia</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item" @click="menu=4">
                                <a class="nav-link" href="#"><i class="icon-arrow-right"></i> Devolucion</a>
                            </li>
                            
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-basket"></i> Ventas</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item" @click="menu=5">
                                <a class="nav-link" href="#"><i class="icon-basket-loaded"></i> Servicios</a>
                            </li>
                            <li class="nav-item" @click="menu=6">
                                <a class="nav-link" href="#"><i class="icon-notebook"></i> Clientes</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-wrench"></i>Taller</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item" @click="menu=7">
                                <a class="nav-link" href="#"><i class="icon-calendar"></i>Mantenimiento</a>
                            </li>
                            
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-people"></i> Acceso</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item" @click="menu=8">
                                <a class="nav-link" href="#"><i class="icon-user"></i> Usuarios</a>
                            </li>
                            <li class="nav-item" @click="menu=9">
                                <a class="nav-link" href="#"><i class="icon-user"></i> Chofer</a>
                            </li>
                            <li class="nav-item" @click="menu=10">
                                <a class="nav-link" href="#"> <i class="icon-user"></i>Vehiculos</a>
                            </li>
                            <li class="nav-item" @click="menu=11">
                                <a class="nav-link" href="#"><i class="icon-user-following"></i> Roles</a>
                            </li>
                        </ul>
                    </li>
                    
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>