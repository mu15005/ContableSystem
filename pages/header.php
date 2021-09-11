 <header class="topbar">
            <nav class="navbar top-navbar navbar-toggleable-sm navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                 <div class="navbar-header">
                    <a class="navbar-brand" href="inicio.php">
                        <!-- Logo icon -->
                        
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span>
                            <!-- dark Logo text -->
                            <img src="../assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                        </span>
                       
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0 ">
                        <!-- This is  -->
                       
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                     <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown">
                            <?php
                           

                             if(isset($_SESSION["usuario"])){
                                $usu=$_SESSION["usuario"];

                                         } 


                            ?>
                            <a  href="micuenta.php" style="font-size: 24px;font-weight: bold;" class="nav-link dropdown-toggle text-muted waves-effect waves-dark"    aria-haspopup="true" aria-expanded="false"><img  src="data:image/jpg;base64,<?php echo base64_encode($usu[3]); ?>" alt="user"  class="profile-pic" /><?php echo  "       ".$usu[1]; ?></a>
                        </li>
                    </ul>
                </div>
            </nav>
           
        </header>