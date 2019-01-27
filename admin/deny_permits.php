<?php
include "../inc/connection.php";
session_start();
$i=$_GET["page"];
if($i=="statusCheck0"){
    $sql="Update permits_request set status='0', deny_description='".$_POST['deny_content']."' where permits_request.id=".$_POST["request_id"];
    $result=$conn->query($sql);
    if($result){
        header("location:".$_SERVER["REMOTE_HOST"]."/izintakip/admin/mail.php?actions=deny_permit_request&permit_id=".$_POST["request_id"]);
        //header("location:".$_SERVER["REMOTE_HOST"]."/izintakip/admin/?page=onaybekleyen&permits=red");
    }
    // UPDATE `permits_request` SET `status` = '2' WHERE `permits_request`.`id` = 8;
}