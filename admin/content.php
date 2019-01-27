<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<?php
include_once "sessionBilgi.php";
?>
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">

            <?php
            if (isset($_GET["update"]) && $_GET["update"] == "basarili") {
                echo '<div class="alert alert-success">
                                <strong>BİLGİ:</strong>Kayıt Güncellendi
                             </div>  ';
            } elseif (isset($_GET["update"]) && $_GET["update"] == "basarisiz") {
                echo '<div class="alert alert-warning">
                                <strong>BİLGİ:</strong>Kayıt Güncelleme Başarısız oldu
                             </div>  ';
            } else if (isset($_GET["delete"]) && $_GET["delete"] == "basarili") {
                echo '<div class="alert alert-success">
                                <strong>BİLGİ:</strong>Kayıt Silindi
                             </div>  ';
            } elseif (isset($_GET["delete"]) && $_GET["delete"] == "basarisiz") {
                echo '<div class="alert alert-warning">
                                <strong>BİLGİ:</strong>Kayıt Silme Başarısız oldu
                             </div>  ';
            } else if (isset($_GET["permits"]) && $_GET["permits"] == "onay") {
                echo '<div class="alert alert-success">
                                <strong>BİLGİ:</strong>İzin Talebi Onaylandı
                             </div>  ';
            } elseif (isset($_GET["permits"]) && $_GET["permits"] == "red") {
                echo '<div class="alert alert-success">
                                <strong>BİLGİ:</strong>İzin Talebi Reddedildi
                             </div>  ';
            } else if (isset($_GET["permit_request"]) && $_GET["permit_request"] == "basarili") {
                echo '<div class="alert alert-success">
                                <strong>BİLGİ:</strong>İzin Talebi Oluşturuldu
                             </div>  ';
            } elseif (isset($_GET["permit_request"]) && $_GET["permit_request"] == "basarisiz") {
                echo '<div class="alert alert-warning">
                                <strong>BİLGİ:</strong>İzin Talebi Oluşturulamadı
                             </div>  ';
            }
            
            elseif (isset($_GET["add"]) && $_GET["add"] == "basarili") {
                echo '<div class="alert alert-success">
                                <strong>BİLGİ:</strong>Kayıt Eklendi
                             </div>  ';
            }
            elseif (isset($_GET["add"]) && $_GET["add"] == "basarisiz") {
                echo '<div class="alert alert-warning">
                                <strong>BİLGİ:</strong>Kayıt Eklenmedi
                             </div>  ';
            }
            
            /*
              switch (@$_GET["page"]){
              case  "useradd":
              include_once './useradd.php';
              break;
              default:
              include_once './user.php';
              break;
              }
             */
            if (isset($_GET["page"])) {
                switch ($_GET["page"]) {
                    case "useradd":
                        include_once './useradd.php';
                        break;
                    case "permits_request":
                        include_once './permits_request.php';
                        break;
                    case "update":
                        include_once './user_update.php';
                        break;
                    case "izintalep":
                        include_once './izintalep.php';
                        break;
                    case "onaybekleyen":
                        include_once './onaybekleyen.php';
                        break;
                    case "onaylanan":
                        include_once './onaylanan.php';
                        break;
                    case "onaylanmayan":
                        include_once './onaylanmayan.php';
                        break;
                    case "statusCheck1":
                        include_once("./save_permits.php");
                        break;
                    case "statusCheck0":
                        include_once("./deny_permits.php");
                        break;
                    case "izin_yonergesi":
                        include_once ("./izin_yonergesi.php");break;
                }
            } else {
                switch ($_SESSION["rol"]) {
                    case 1:
                        include_once './user.php';
                        break;
                    case 2:
                        include_once './user_dashboard.php';
                        break;
                }
            }
            ?>


        </div> <!-- container -->

    </div> <!-- content -->

    <footer class="footer text-right">
        2018 © 
    </footer>

</div>


<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->