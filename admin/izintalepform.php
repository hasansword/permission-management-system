<?php


include "../inc/connection.php";
require_once 'crypto.php';
session_start();
if (isset($_POST)) {

    date_default_timezone_set('Europe/Istanbul');

    $baslangic = strtotime($_POST["izinbaslangic"]);
    $bitis = strtotime($_POST["izinbitis"]);


    if ($baslangic > $bitis) {
        
        header("Location:/izintakip/admin/index.php?page=izintalep&permit_request=tarihbasarisiz");
        exit;
    } else {




        $sql = "SELECT start_work FROM users_profile WHERE user_id = '" . $_SESSION["id"] . "'";
        $result = $conn->query($sql);
        $user = mysqli_fetch_array($result);

        $start_work = strtotime($user["start_work"]);
        $bugun = strtotime('today UTC');
        $work_day = ($bugun - $start_work) / 86400;

        if ($work_day < 365 && $_POST["izinturu"] == 2) {
            header("Location:/izintakip/admin/index.php?page=izintalep&permit_request=basarisiz");
        } else {
            $baslangic = strtotime($_POST["izinbaslangic"]);
            $bitis = strtotime($_POST["izinbitis"]);
            $fark = ($bitis - $baslangic) / 86400;

            $komut = "INSERT INTO `permits_request` ( `user_id`, `permit_id`, `permit_request_day`, `permit_start_date`, `permit_end_date`, `description`, `status`) VALUES ( '" . $_SESSION["id"] . "', '" . $_POST["izinturu"] . "', '" . $fark . "', '" . $_POST["izinbaslangic"] . "', '" . $_POST["izinbitis"] . "', '" . $_POST["aciklama"] . "', '1')";
            $donus = $conn->query($komut);
            if ($donus) {
                $sql = "SELECT *,(SELECT id FROM permits_request ORDER BY id DESC LIMIT 1) as permit_id FROM users INNER JOIN users_profile ON users.id = users_profile.user_id WHERE users.status = 1 AND user_id=" . $_SESSION["id"];
                $result = mysqli_fetch_array($conn->query($sql));
                header("Location:/izintakip/admin/mail.php?actions=permit_request_mail&name=" . $result['name'] . "&permit=" . encrypt_decrypt('encrypt', $result['permit_id']));
                //header("Location:/izintakip/admin/index.php?page=izintalep&permit_request=basarili");
            }
        }
    }
}