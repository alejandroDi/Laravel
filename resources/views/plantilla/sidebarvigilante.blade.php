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
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-eye"></i> Vigilancia</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item" @click="menu=4">
                                <a class="nav-link" href="#"><i class="icon-arrow-right"></i> Devolucion</a>
                            </li>
                            
                        </ul>
                    </li>
                    
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>