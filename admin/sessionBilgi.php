<?php
ob_start();
if(!$_SESSION["login"]){
    exit();
        echo "<script>alert('Bu sayfayı görmeye yetkiniz yok');</script>";
}
?>

