<?php
session_start();
    include "../inc/connection.php";
    if($_POST){
        $user=$_POST["user"];
        $pass=$_POST["pass"];
        if(empty($user)|| empty($pass)){
            echo "<script>alert('Eksik Bilgi');</script>";
        }else{
            $sorgu="select * from users where email='".$user."' and password='".md5($pass)."' AND status = 1";
            $result=$conn->query($sorgu);
            
            if(mysqli_num_rows($result)>0){
                $uArray=mysqli_fetch_array($result);
                $_SESSION["login"]=true;
            $_SESSION["rol"]=$uArray["role"];
            $_SESSION["id"]=$uArray["id"];
            header("location:index.php");
            }
        }
    }

if(isset($_GET["mail"]) && $_GET["mail"] == "basarili"){
    echo '<div class="alert alert-success">
                                <strong>BİLGİ:</strong>Şifre Sıfırlama Maili İletildi
                             </div>  ';
}elseif(isset($_GET["mail"]) && $_GET["mail"] == "basarisiz"){
    echo '<div class="alert alert-warning">
                                <strong>BİLGİ:</strong>Şifre Sıfırlama Maili İletilemedi
                             </div>  ';
}
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- App title -->
        <title>İzin Takip - Giriş Paneli</title>

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="assets/js/modernizr.min.js"></script>

    </head>


    <body class="bg-transparent">
        
        <!-- HOME -->
    <section>
        <div class="container-alt">
            <div class="row">
                <div class="col-sm-12">

                    <div class="wrapper-page">

                        <div class="m-t-40 account-pages">
                            <div class="text-center account-logo-box">
                                <h2 class="text-uppercase">
                                    <a class="text-success">
                                        <span>Giriş Paneli</span>
                                    </a>    
                                </h2>
                                <!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
                            </div>
                            <div class="account-content">
                                <form class="form-horizontal" action="#" method="POST">

                                    <div class="form-group ">
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text" required="" name="user" placeholder="Kullanıcı Adı">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <input class="form-control" type="password" required="" name="pass" placeholder="Şifre" id="myInput"><input type="checkbox" onclick="myFunction()"> Şifreyi Göster
                                                
                                                <script>
                                                function myFunction() {
                                                        var x = document.getElementById("myInput");
                                                        if (x.type === "password") {
                                                            x.type = "text";
                                                        } else {
                                                            x.type = "password";
                                                        }
                                                    }
                                                </script>
                                        </div>
                                    </div>

                                 

                                    <div class="form-group text-center m-t-30">
                                        <div class="col-sm-12">
                                            <a href="forgot_password.php" class="text-muted"><i class="fa fa-lock m-r-5"></i> Şifremi unuttum.</a>
                                        </div>
                                    </div>

                                    <div class="form-group account-btn text-center m-t-10">
                                        <div class="col-xs-12">
                                            <button class="btn w-md btn-bordered btn-danger waves-effect waves-light" type="submit">Giriş Yap</button>
                                        </div>
                                    </div>

                                </form>

                                <div class="clearfix"></div>

                            </div>
                        </div>
                        <!-- end card-box-->



                    </div>
                    <!-- end wrapper -->

                </div>
            </div>
        </div>
    </section>
    <!-- END HOME -->

    <script>
        var resizefunc = [];
    </script>

    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>

    <!-- App js -->
    <script src="assets/js/jquery.core.js"></script>
    <script src="assets/js/jquery.app.js"></script>

</body>
</html>