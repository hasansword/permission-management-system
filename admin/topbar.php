<?php
    include_once "sessionBilgi.php";
	include_once "../inc/connection.php";
?>

<!-- Top Bar Start -->
<div class="topbar">

    <!-- LOGO -->
    <div class="topbar-left">
        <a href="index.php" class="logo"><span>İZİN <span>YÖNETİMİ</span></span><i class="mdi mdi-layers"></i></a>
        <!-- Image logo -->
        <!--<a href="index.html" class="logo">-->
            <!--<span>-->
                <!--<img src="assets/images/logo.png" alt="" height="30">-->
        <!--</span>-->
        <!--<i>-->
            <!--<img src="assets/images/logo_sm.png" alt="" height="28">-->
        <!--</i>-->
        <!--</a>-->
    </div>

    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">

            <!-- Navbar-left -->
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <button class="button-menu-mobile open-left waves-effect">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </li>
                <?php
				if($_SESSION["rol"] == 1){
				?>
                <li>
                    <a href="?page=onaybekleyen" class="right-menu-item dropdown-toggle">
                        <i class="mdi mdi-bell"></i>
                        <?php
							$sql="select * from permits_request where status = 1";
							$result=mysqli_num_rows( $conn->query($sql));
						if($result > 0){
							echo '<span class="badge up bg-success">'.($result-1).'</span>';
						}
                                                else echo '<span class="badge up bg-success">'."".'</span>';
						?>
                       
                        
                    </a>
<!--
                    <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right dropdown-lg user-list notify-list">
                        <li>
                            <h5>Bildirim</h5>
                        </li>
                        <li>
                            <a href="#" class="user-list-item">
                                <div class="icon bg-info">
                                    <i class="mdi mdi-account"></i>
                                </div>
                                <div class="user-desc">
                                    <span class="name">İzin Talebi</span>
                                    <span class="time">2 saat önce</span>
                                </div>
                            </a>
                        </li>
                    </ul>-->
                </li>
                <?php
				}
				?>
            </ul>
            <!--<a href="cikis.php"  class="btn btn-inverse waves-effect w-md waves-light m-b-5">Çıkış</a>-->
            <ul class="nav navbar-nav navbar-right">


                <li>
                    <a href="cikis.php" class="right-bar-toggle right-menu-item" title="Çıkış yap">
                        <i class="fa fa-sign-out"></i>
                    </a>
                </li>

            </ul> <!-- end navbar-right -->




        </div><!-- end container -->
    </div><!-- end navbar -->
</div>
<!-- Top Bar End -->