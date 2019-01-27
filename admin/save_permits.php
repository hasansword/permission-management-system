<?php
include "../inc/connection.php";
session_start();
$i=$_GET["page"];
if($i=="statusCheck1"){
	$sql="Update permits_request set status='2' where permits_request.id=".$_GET["id"];
	$result=$conn->query($sql);
	if($result){
        header("location:".$_SERVER["REMOTE_HOST"]."/izintakip/admin/mail.php?actions=allow_permit_request&permit_id=".$_GET['id']);
        //header("location:".$_SERVER["REMOTE_HOST"]."/izintakip/admin/?page=onaybekleyen&permits=onay");
    }
	// UPDATE `permits_request` SET `status` = '2' WHERE `permits_request`.`id` = 8;
}