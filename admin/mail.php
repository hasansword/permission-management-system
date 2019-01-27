<?php
include "PHPMailer/class.phpmailer.php";
include "../inc/connection.php";
include "crypto.php";

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Host = 'rc02.srvpanel.com';
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';
$mail->Username = 'no-reply@4kyazilim.com';
$mail->Password = 'oPn!s(W0l?*M';
$mail->SetFrom('no-reply@4kyazilim.com', 'İzin Takip Sistemi');
$mail->addReplyTo('', '');
$mail->CharSet = 'UTF-8';

if($_GET["actions"] == "permit_request_mail") {
    $sql = "SELECT * FROM users INNER JOIN users_profile ON users.id = users_profile.user_id WHERE users.role = 1 AND users.status = 1 LIMIT 1";
    $user = mysqli_fetch_array( $conn->query( $sql ) );
    $sql2 = "SELECT *,(SELECT name FROM permits WHERE id = permits_request.permit_id LIMIT 1) as permits_name FROM permits_request WHERE id= '".encrypt_decrypt('decrypt', $_GET["permit"])."'";
    $request = mysqli_fetch_array( $conn->query( $sql2 ) );


    $mail->AddAddress($user['email'], $user['name']);
    $mail->Subject = 'Yeni İzin Talebi';
    $mail->MsgHTML('<div style="background: #eee; padding: 10px; font-size: 14px">'.$_GET["name"].' Kişisi Yeni Bir İzin Talebinde Bulundu.<br>
İzin Türü: '.$request["permits_name"].' <br> Başlangıç: '.$request['permit_start_date'].' <br> Bitiş: '.$request["permit_end_date"].' <br> Açıklama: '.$request['description'].' <br><br>
<a href="http://4kyazilim.com/izintakip/admin/mail_permit_action.php?action=allow&permit='.$_GET['permit'].'">ONAYLA</a><br>
<a href="http://4kyazilim.com/izintakip/admin/mail_permit_action.php?action=deny&permit='.$_GET['permit'].'">REDDET</a></div>');
    if($mail->Send()) {
        header("Location:/izintakip/admin/index.php?request=basarili");
    } else {
        header("Location:/izintakip/admin/index.php?request=basarisiz");
    }
}else if($_GET["actions"] == "forgot_password") {
    $sql = "SELECT users.id as user_id, users.*, users_profile.* FROM users INNER JOIN users_profile ON users.id = users_profile.user_id WHERE users.email = '".$_POST['email']."' AND users.status = 1";
    $result = mysqli_fetch_array( $conn->query( $sql ) );

    $user_id = encrypt_decrypt('encrypt', $result['user_id']);

    $mail->AddAddress($result['email'], $result['name']);
    $mail->Subject = 'Şifremi Unuttum';
    $mail->MsgHTML('<div style="background: #eee; padding: 10px; font-size: 14px"><a href="http://4kyazilim.com/izintakip/admin/reset_password.php?users='.$user_id.'">Şifre Sıfırlama</a></div>');
    if($mail->Send()) {
        header("Location:/izintakip/admin/login.php?mail=basarili");
    } else {
        header("Location:/izintakip/admin/login.php?mail=basarisiz");
    }
}else if($_GET["actions"] == "allow_permit_request") {
    $sql = "SELECT users.id as user_id, users.*, users_profile.* FROM users INNER JOIN users_profile ON users.id = users_profile.user_id WHERE users.id = (SELECT user_id FROM permits_request WHERE id = '".$_GET['permit_id']."' LIMIT 1) AND users.status = 1";
    $result = mysqli_fetch_array( $conn->query( $sql ) );

    $mail->AddAddress($result['email'], $result['name']);
    $mail->Subject = 'İzin Talebi Hakkında';
    $mail->MsgHTML('<div style="background: #eee; padding: 10px; font-size: 14px">İzin Talebiniz Onaylanmıştır.</div>');
    if($mail->Send()) {
        if($_GET['mail']){
            header("location:".$_SERVER["REMOTE_HOST"]."/izintakip/admin/mail_permit_action.php?actions=allow&mail=true");
        }else {
            header("location:".$_SERVER["REMOTE_HOST"]."/izintakip/admin/?page=onaybekleyen&permits=onay");
        }
    } else {
        if($_GET['mail']){
            header("location:".$_SERVER["REMOTE_HOST"]."/izintakip/admin/mail_permit_action.php?actions=allow&mail=true");
        }else {
            header("location:".$_SERVER["REMOTE_HOST"]."/izintakip/admin/?page=onaybekleyen&permits=onay");
        }
    }
}else if($_GET["actions"] == "deny_permit_request") {
    $sql = "SELECT users.id as user_id, users.*, users_profile.*, (SELECT deny_description FROM permits_request WHERE id = '".$_GET['permit_id']."' LIMIT 1) as deny_description FROM users INNER JOIN users_profile ON users.id = users_profile.user_id WHERE users.id = (SELECT user_id FROM permits_request WHERE id = '".$_GET['permit_id']."' LIMIT 1) AND users.status = 1";
    $result = mysqli_fetch_array( $conn->query( $sql ) );

    $mail->AddAddress($result['email'], $result['name']);
    $mail->Subject = 'İzin Talebi Hakkında';
    $mail->MsgHTML('<div style="background: #eee; padding: 10px; font-size: 14px">İzin Talebiniz Reddedilmiştir. '.(($result["deny_description"] != NULL)? '<br><br> Nedeni: <br> '.$result["deny_description"].'</div>' : ""));
    if($mail->Send()) {
        if($_GET['mail']){
            header("location:".$_SERVER["REMOTE_HOST"]."/izintakip/admin/mail_permit_action.php?actions=deny&mail=true");
            
        }else {
            header("location:".$_SERVER["REMOTE_HOST"]."/izintakip/admin/?page=onaybekleyen&permits=red");
        }
    } else {
         if($_GET['mail']){
            header("location:".$_SERVER["REMOTE_HOST"]."/izintakip/admin/mail_permit_action.php?actions=deny&mail=true");
        }else {
            header("location:".$_SERVER["REMOTE_HOST"]."/izintakip/admin/?page=onaybekleyen&permits=red");
        }
    }
}

?>

