<?php

include "../inc/connection.php";
$i=$_GET["i"];
if($i=="useradd") {
        $sql="INSERT INTO users (email, password, role) VALUES('".$_POST['email']."', '".$_POST['password']."', 2)";
        $result=$conn->query($sql);

        if($result){
            $sql="INSERT INTO users_profile (user_id, name, phone, type, start_work, department) VALUES((SELECT id FROM users WHERE status = 1 ORDER BY id DESC LIMIT 1), '".$_POST['nameSurname']."', '".preg_replace('/[^0-9]/', '', $_POST['phone'])."', '".$_POST['userType']."', '".date_format(date_create($_POST['start_work']),"Y-m-d")."','".$_POST['department']."')";
            $result=$conn->query($sql);
            if($result) {
                header("location:index.php");
            }
        }
    }else if($i=="user_update"){
        
           // $sql="Update  users INNER JOIN users_profile ON users.id = users_profile.user_id INNER JOIN on bolumler.id=users_profile.department set name='".$_POST['nameSurname']."',email='".$_POST['email']."', phone='".$_POST['phone']."', type='".$_POST['userType']."', start_work='".$_POST['start_work']."', department='".$_POST['bolumBilgisi']."'  where users.status = 1 user_id=".$_GET['id'];
            $sql =  "Update users INNER JOIN users_profile ON users.id = users_profile.user_id set name='".$_POST['nameSurname']."',email='".$_POST['email']."', phone='".$_POST['phone']."', type='".$_POST['userType']."', start_work='".$_POST['start_work']."', department='".$_POST['bolumBilgisi']."' where users.status = 1 and user_id=".$_GET['id'];
            $result=$conn->query($sql);
           // print_r($result->errorInfo());
            
            if($result){
                header("location:".$_SERVER["REMOTE_HOST"]."/izintakip/admin/?update=basarili");
            }else{
                header("location:".$_SERVER["REMOTE_HOST"]."/izintakip/admin/?update=basarisiz");
            }   
        
            
    }else if($i=="delete") {

    $sql = "UPDATE users SET status = 0 WHERE id=" . $_GET['id'];

    $result = $conn->query($sql);
    if ($result) {
        $sql = "UPDATE users_profile SET status = 0 WHERE user_id=" . $_GET['id'];

        $result = $conn->query($sql);
        if ($result) {
            header("location:" . $_SERVER["REMOTE_HOST"] . "/izintakip/admin/?delete=basarili");
        } else {
            header("location:" . $_SERVER["REMOTE_HOST"] . "/izintakip/admin/?delete=basarisiz");
        }
    } else {
        header("location:" . $_SERVER["REMOTE_HOST"] . "/izintakip/admin/?delete=basarisiz");
    }
}