 <!-- ========== Left Sidebar Start ========== -->
<?php
    include_once "sessionBilgi.php";
?>
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul>
                <li class="menu-title">Panel</li>
                <?php
                if ($_SESSION["rol"] == 1) {
                    ?>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-view-dashboard"></i><span> Kullanıcı </span> </a>
                        <ul class="list-unstyled" style="display: block">
                            <li><a href="?page=onaylanan">Onaylanan İzinler</a></li>
                            <li><a href="?page=onaybekleyen">Onay Bekleyenler</a></li>
                            <li><a href="?page=onaylanmayan">Onaylanmayan İzinler</a></li>
                            <li><a href="?page=izin_yonergesi">İzin Yönergesi</a></li>
                        </ul>
                    </li>
                    <?php
                } else if ($_SESSION["rol"] == 2) {
                    ?>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-view-dashboard"></i><span> İşlemler </span> </a>
                        <ul class="list-unstyled"  style="display: block">
                            <li><a href="index.php?page=izintalep">Yeni İzin Talebi</a></li>
                            <li><a href="index.php?page=permits_request">İzin Taleplerim</a></li>
                            <li><a href="index.php?page=izin_yonergesi">İzin Yönergesi</a></li>
                        </ul>
                    </li>
                    <?php
                }
                ?>




            </ul>
        </div>
    </div>
    <!-- Sidebar -left -->

</div>

<!-- Left Sidebar End -->