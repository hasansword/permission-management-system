<?php
session_start();
if($_SESSION["login"]){
    

include "../inc/connection.php";

include_once './head.php';
include_once './topbar.php';
include_once './sidebar.php';
include_once './content.php';
include_once './footer.php';
}
else{
    header("location:login.php");
}

