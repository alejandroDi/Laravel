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
                    
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>