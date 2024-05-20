            <!-- Navbar Start -->
            <nav class="navigation">
                <ul class="list-unstyled">
                    <li class="active"><a href="<?=base_url()?>"><i class="ion-home"></i> <span class="nav-label">Página inicial</span></a></li>
                    
                    <li class="has-submenu"><a href="#"><i class="ion-android-social"></i> <span class="nav-label">Clientes</span></a>
                        <ul class="list-unstyled">
                            <li><a href="<?=base_url()?>clientes">Clientes</a></li>
                            <li><a href="<?=base_url()?>clientes/incluir">Novo cliente</a></li>
                            <li><a href="<?=base_url()?>negativados">Negativados</a></li>
                        </ul>
                    </li>

                    <li class="has-submenu"><a href="#"><i class="ion-briefcase"></i> <span class="nav-label">Contrato</span></a>
                        <ul class="list-unstyled">
                            <li><a href="<?=base_url()?>contratos/incluir">Novo contrato</a></li>
                        </ul>
                    </li>

                    <li class="has-submenu"><a href="#"><i class="fa fa-tag"></i> <span class="nav-label">Categorias</span></a>
                        <ul class="list-unstyled">
                            <li><a href="<?=base_url()?>categorias">Categorias</a></li>
                            <li><a href="<?=base_url()?>categorias/incluir">Nova categoria</a></li>
                        </ul>
                    </li>


                    <li class="has-submenu"><a href="#"><i class="fa fa-user"></i> <span class="nav-label">Cobradores</span></a>
                        <ul class="list-unstyled">
                            <li><a href="<?=base_url()?>cobradores">Cobradores</a></li>
                            <li><a href="<?=base_url()?>cobradores/incluir">Novo cobrador</a></li>
                        </ul>
                    </li>


                    <li class="has-submenu"><a href="#"><i class="ion-flag"></i> <span class="nav-label">Status</span></a>
                        <ul class="list-unstyled">
                            <li><a href="<?=base_url()?>status">Status</a></li>
                            <li><a href="<?=base_url()?>status/incluir">Novo status</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
                
        </aside>
        <!-- Aside Ends-->