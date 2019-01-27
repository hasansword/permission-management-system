<?php
include "../inc/connection.php";
require_once 'crypto.php';

if($_GET["permit"] && $_GET["action"]){
    $permit_id = encrypt_decrypt('decrypt', $_GET["permit"]);

    if($_GET["action"] == "allow") {
        /*$sorgu="select * from permits_request where id = '".$permit_id."' and status = 1";
        $result=$conn->query($sorgu);

        if(mysqli_num_rows($result)>0){

        }*/
        $sorgu="select * from permits_request where id = '".$permit_id."' and status = 1";
        $result=$conn->query($sorgu);
        if(mysqli_num_rows($result)>0){
            $sql="Update permits_request set status='2' where permits_request.id=".$permit_id;
            $result=$conn->query($sql);
            if($result){
                header("location:".$_SERVER["REMOTE_HOST"]."/izintakip/admin/mail.php?actions=allow_permit_request&permit_id=".$permit_id."&mail=true");
            }
        }else {
            echo '<div class="alert alert-danger">
                                İzin Talebi <strong>Bulunamadı</strong>
                             </div>';
        }
    }else if($_GET["action"] == "deny") {
        $sorgu="select * from permits_request where id = '".$permit_id."' and status = 1";
        $result=$conn->query($sorgu);
        if(mysqli_num_rows($result)>0){
            $sql="Update permits_request set status='0' where permits_request.id=".$permit_id;
            $result=$conn->query($sql);
            if($result){
                header("location:".$_SERVER["REMOTE_HOST"]."/izintakip/admin/mail.php?actions=deny_permit_request&permit_id=".$permit_id."&mail=true");
            }
        }else {
            echo '<div class="alert alert-danger">
                                İzin Talebi <strong>Bulunamadı</strong>
                             </div>';
        }
    }
}else if(isset($_GET['actions']) && isset($_GET['mail'])){
    if($_GET['actions'] == "allow"){
        echo '<div class="alert alert-success">
                                İzin Talebi Başarılı Bir Şekilde <strong>Onaylandı</strong>
                             </div>';
    }else if($_GET['actions'] == "deny"){
        echo '<div class="alert alert-success">
                                İzin Talebi Başarılı Bir Şekilde <strong>Reddedildi</strong>
                             </div>';
    }
}
?>
<html>
<head>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
</head>
</html>