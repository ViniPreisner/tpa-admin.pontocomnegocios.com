        <!--Main Content Start -->
        <section class="content">
            
            <!-- Header -->
            <header class="top-head container-fluid">
                <button type="button" class="navbar-toggle pull-left">
                    <span class="sr-only">Navegação</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <!-- Search -->
                <form role="search" method="get" action="/clientes/busca" class="navbar-left app-search pull-left hidden-xs">
                  <input type="text" placeholder="Busca rápida..." class="form-control" name="term">
                  <a href=""><i class="fa fa-search"></i></a>
                </form>
                
                <!-- Left navbar -->
                

                    <!-- Right navbar -->
                    <ul class="nav navbar-nav navbar-right top-menu top-right-menu">  
                        <!-- user login dropdown start-->
                        <li class="dropdown text-center">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <!-- <img alt="" src="img/avatar-2.jpg" class="img-circle profile-img thumb-sm"> -->
                                <i class="ion-person"></i>
                                <span class="username"><?=$userdata['userName']?> </span> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu pro-menu fadeInUp animated" tabindex="5003" style="overflow: hidden; outline: none;">
                                <!-- <li><a href="profile.html"><i class="fa fa-briefcase"></i>Meus dados</a></li> -->
                                <li><a href="<?=base_url()?>logout"><i class="fa fa-sign-out"></i> Log Out</a></li>
                            </ul>
                        </li>
                        <!-- user login dropdown end -->       
                    </ul>
                    <!-- End right navbar -->
                </nav>
                
            </header>
            <!-- Header Ends -->