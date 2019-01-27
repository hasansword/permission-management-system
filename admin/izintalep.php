<?php
include "../inc/connection.php";
$sql = "SELECT *,(SELECT SUM(permit_request_day) FROM permits_request WHERE user_id = " . $_SESSION['id'] . " AND status = 2) as use_permit FROM users INNER JOIN users_profile ON users.id = users_profile.user_id INNER Join bolumler on bolumler.id=users_profile.department WHERE users.status=1 AND user_id=" . $_SESSION["id"];
$result = mysqli_fetch_array($conn->query($sql));

$baslangic = strtotime($result['start_work']);
$bugun = strtotime('today UTC');
$fark = ($bugun - $baslangic) / 86400;

$yil = intval($fark / 365);


if ($yil <= 5) {
    $result['total_permit'] = $yil * 14;
} else if ($yil > 5 && $yil <= 15) {
    $result['total_permit'] = (5 * 14) + (($yil - 5) * 20);
} else {
    $result['total_permit'] = (5 * 14) + (10 * 20) + (($yil - 15) * 26);
}


if (isset($_GET['permit_request']) && $_GET['permit_request'] == "basarisiz") {
    echo '<div class="alert alert-warning">
                                <strong>BİLGİ:</strong>Yıllık izin hakkınız olmadan mazeret izni talep edemezsiniz.
                             </div>  ';
}
else if (isset($_GET['permit_request']) && $_GET['permit_request'] == "tarihbasarisiz") {
    echo '<div class="alert alert-warning">
                                <strong>BİLGİ:</strong>Başlangıç tarihi bitiş tarihinden büyük olamaz!
                             </div>  ';
}
?>

<div class="row">
    <div class="col-xs-12">
        <div class="card-box">
            <div class="row">
                <div class="col-sm-12 col-xs-12 col-md-6">
                    <h4 class="header-title m-t-0">İzin Talep Formu</h4>
                    <p class="text-muted font-13 m-b-10">

                    </p>

                    <div class="p-20">
                        <form role="form" data-parsley-validate novalidate action="izintalepform.php" method="post" id="izintalepolustur">
                            <div class="form-group row">
                                <label for="nameSurname" class="col-sm-4 form-control-label">Ad Soyad<span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <input type="text-danger" value="<?php echo $result['name'] ?>" disabled required parsley-type="text-danger" class="form-control" id="nameSurname" name="nameSurname"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bolum" class="col-sm-4 form-control-label">Bölüm<span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <input type="bolum" value="<?php echo $result['bolum'] ?>" disabled required parsley-type="bolum" class="form-control" id="bolum" name="department">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="izinbaslangic" class="col-sm-4 form-control-label">İzin Başlangıç Tarihi<span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <input required type="text" class="form-control date_picker" id="izinbaslangic" name="izinbaslangic" placeholder="GG-AA-YYYY">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="izinbitis" class="col-sm-4 form-control-label">İzin Bitiş Tarihi<span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <input type="text" required class="form-control date_picker" id="izinbitis" name="izinbitis" placeholder="GG-AA-YYYY">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kalan" class="col-sm-4 form-control-label">Kalan İzin Hakkınız<span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <input type="text" value="<?= ($result['total_permit'] - $result['use_permit']) ?>" disabled parsley-type="kalan" class="form-control" id="kalan" name="kalan">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="izinturu" class="col-sm-4 form-control-label">Talep Edilen İzin Türü<span class="text-danger">*</span></label>
                                <div class="col-sm-7">

                                    <select class="form-control" name="izinturu" onchange="formKontrol()" id="izinTuru">
                                        <option>Seçiniz</option>
                                        <?php
                                        $list = "SELECT * FROM permits";
                                        $result = $conn->query($list);
                                        while ($row = mysqli_fetch_array($result)) {

                                            echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row" >
                                <label for="aciklama" class="col-sm-4 form-control-label">Açıklama<span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <textarea id="aciklama" required class="form-control" rows="5" name="aciklama"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-8 col-sm-offset-4">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="saveUser">
                                        Talep Oluştur
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
    var kalan_izin = 0;
    $(document).ready(function () {
        kalan_izin = parseInt($("#kalan").val());
    });

    function formKontrol() {
        var izinturu = document.getElementById("izinTuru").selectedIndex;
        if (izinturu == 1) {
            document.getElementById("aciklama").value = "Yıllık izin";

        } else {
            document.getElementById("aciklama").value = "";
        }
    }

    $(document).on("change", "#izinbitis", function () {
        if ($("#izinbaslangic").val() == "" || $("#izinbitis").val() == "")
            return;

        var baslangic = $("#izinbaslangic").val();
        baslangic = baslangic.split("-");
        baslangic = new Date(baslangic[2] + "-" + baslangic[1] + "-" + baslangic[0]);

        var bitis = $("#izinbitis").val();
        bitis = bitis.split("-");
        bitis = new Date(bitis[2] + "-" + bitis[1] + "-" + bitis[0]);

        var kalan = kalan_izin - ((bitis - baslangic) / (1000 * 60 * 60 * 24));

        $("#kalan").val(kalan);
    });

    $(document).on("change", "#izinbaslangic", function () {
        if ($("#izinbaslangic").val() == "" || $("#izinbitis").val() == "")
            return;

        var baslangic = $("#izinbaslangic").val();
        baslangic = baslangic.split("-");
        baslangic = new Date(baslangic[2] + "-" + baslangic[1] + "-" + baslangic[0]);

        var bitis = $("#izinbitis").val();
        bitis = bitis.split("-");
        bitis = new Date(bitis[2] + "-" + bitis[1] + "-" + bitis[0]);

        var kalan = kalan_izin - ((bitis - baslangic) / (1000 * 60 * 60 * 24));

        $("#kalan").val(kalan);
    });

</script>



















