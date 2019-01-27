<?php
include "sessionBilgi.php";
if ($_POST) {
    $sql = "SELECT * FROM users WHERE email = '" . $_POST['email'] . "' AND status = 1";
    $result = $conn->query($sql);
    if (mysqli_num_rows($result) <= 0) {
        $sql = "INSERT INTO users (email, password, role) VALUES('" . $_POST['email'] . "', '" . md5($_POST['password']) . "', 2)";
        $result = $conn->query($sql);

        if ($result) {
            $sql = "INSERT INTO users_profile (user_id, name, phone, type, start_work, department) VALUES((SELECT id FROM users WHERE status = 1 ORDER BY id DESC LIMIT 1), '" . $_POST['nameSurname'] . "', '" . preg_replace('/[^0-9]/', '', $_POST['phone']) . "', '" . $_POST['userType'] . "', '" . date_format(date_create($_POST['start_work']), "d-m-Y") . "','" . $_POST['bolumBilgisi'] . "')";
            $result = $conn->query($sql);
            if ($result) {
                header("location:index.php?add=basarili");
            } else {
                header("location:index.php?add=basarisiz");
            }
        }
    } else {
        echo '<div class="alert alert-success">
                                <strong>BİLGİ:</strong>Girdiğiniz E-posta Adresi Sistemde Kayıtlı
                             </div>  ';
    }
}
?>
<div class="row">
    <div class="col-xs-12">
        <div class="card-box">
            <div class="row">
                <div class="col-sm-12 col-xs-12 col-md-6">
                    <h4 class="header-title m-t-0">Kullanıcı Ekleme Formu</h4>
                    <p class="text-muted font-13 m-b-10">

                    </p>

                    <div class="p-20">
                        <form role="form" data-parsley-validate novalidate action="" method="post">
                            <div class="form-group row">
                                <label for="nameSurname" class="col-sm-4 form-control-label">Ad Soyad<span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <input type="text-danger" required parsley-type="text-danger" class="form-control"  id="nameSurname" name="nameSurname" placeholder="Ad,Soyad"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 form-control-label">E-posta<span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <input type="email" required parsley-type="email" class="form-control" id="email" name="email" placeholder="E-posta">
                                </div>
                            </div>
                            <!--
                            <div class="form-group row">
                                <label for="rol" class="col-sm-4 form-control-label">Kullanıcı Adı</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Kullanıcı Adınız" readonly/>
                                </div>
                            </div>
                            -->
                            <div class="form-group row">
                                <label for="phone" class="col-sm-4 form-control-label">Telefon<span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <input type="tel" required parsley-type="text-danger" class="form-control" id="phone" name="phone" data-mask="(999) 999-9999" placeholder="Telefon"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="personelTuru" class="col-sm-4 form-control-label">Personel Türü<span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <select name="userType" id="userType" class="form-control" required parsley-type="text-danger">
                                        <option value="1">İdari</option>
                                        <option value="2">Akademik</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="iseBaslangic" class="col-sm-4 form-control-label">İşe Başlangıç Tarihi<span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control date_picker" id="start_work" name="start_work" placeholder="GG-AA-YYYY">
                                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="form-group row">
                                <label for="bolumBilgisi" class="col-sm-4 form-control-label">Bölüm Bilgisi<span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <input type="text-danger" required parsley-type="text-danger" class="form-control"  id="department" name="department" placeholder="Bölüm Bilgisi"/>
                                </div>
                            </div>-->
                            <div class="form-group row">
                                <label for="bolumBilgisi" class="col-sm-4 form-control-label">Bölüm Bilgisi<span class="text-danger">*</span></label>
                                <div class="col-sm-7">

                                    <select class="form-control" name="bolumBilgisi" onchange="formKontrol()" id="bolumBilgisi">
                                        <option>Seçiniz</option>
                                        <?php
                                        $list = "SELECT * FROM bolumler order by bolum asc";
                                        $result = $conn->query($list);
                                        while ($row = mysqli_fetch_array($result)) {

                                            echo "<option id='department' name='department' value='" . $row["id"] . "'>" . $row["bolum"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="hori-pass1" class="col-sm-4 form-control-label">Şifre<span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <input id="password" name="password" type="password" placeholder="Şifre" required class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="hori-pass2" class="col-sm-4 form-control-label">Şifre Onay
                                    <span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <input data-parsley-equalto="#password" type="password" required placeholder="Şifre" class="form-control" id="password2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8 col-sm-offset-4">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="saveUser">
                                        Ekle
                                    </button>

                                </div>
                            </div>
                        </form>
                        <a href="/izintakip/admin/index.php"> <button type="submit" class="btn btn-default waves-effect m-l-5"> İptal </button></a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<script>
    /*
     $(document).on("keyup", "#email", function () {
     var username = "";
     if($(this).val().indexOf("@") == -1) {
     username = $(this).val();
     }else {
     username = $(this).val().split("@")[0];
     }
     $('#username').val(username);
     });
     */
</script>

