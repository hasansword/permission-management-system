<?php
include_once"sessionBilgi.php";



$sql = "SELECT name, bolum, start_work,(SELECT SUM(permit_request_day) FROM permits_request WHERE user_id = " . $_SESSION['id'] . " AND status = 2) as use_permit, (SELECT SUM(permit_request_day) FROM permits_request WHERE (permit_id = 1 OR permit_id = 7) AND user_id = " . $_SESSION['id'] . " AND status = 2) as use_permit_extra FROM users_profile INNER JOIN bolumler on bolumler.id=users_profile.department WHERE user_id = " . $_SESSION['id'];

$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {

    $user = mysqli_fetch_array($result);

    $baslangic = strtotime($user["start_work"]);
    $bugun = strtotime('today UTC');
    $fark = ($bugun - $baslangic) / 86400;

    $yil = intval($fark / 365);
    if ($yil <= 5) {
        $user['total_permit'] = $yil * 14;
    } else if ($yil > 5 && $yil <= 15) {
        $user['total_permit'] = (5 * 14) + (($yil - 5) * 20);
    } else {
        $user['total_permit'] = (5 * 14) + (10 * 20) + (($yil - 15) * 26);
    }

    if ($fark >= 365) {
        $user['remaining_permit'] = 365 - ($fark % 365);
    } else {
        $user['remaining_permit'] = 365 - $fark;
    }
}
?>

<div class="row">

    <div class="col-sm-12">

        <div class="card-box table-responsive">

            <h3 class="m-t-0"><i class="fa fa-user"></i> <b><?= $user['name'] ?> | izin bilgilerim</b></h3>
            <hr>

            <div class="form-group row">




                <div class="col-md-5">

                    <label>Bölüm</label>
                    <br><br>

                    <input type="text" class="form-control" value="<?= $user['bolum'] ?>" readonly>

                </div>

                <div class="col-md-2">

                    <label>İşe Başlangıç Tarihi</label>
                    <br><br>

                    <input type="text" class="form-control" value="<?= date_format(date_create($user['start_work']), "d-m-Y") ?>" readonly>

                </div>



                <div class="col-md-2">

                    <label>İzin Hakkına Kalan Gün</label>
                    <br><br>

                    <input type="text" class="form-control" value="<?= $user['remaining_permit']; ?>" readonly>

                </div>

                <div class="col-md-1">

                    <label >Toplam İzin Süresi</label>
                    <br>

                    <input  type="text" class="form-control" value="<?= $user['total_permit'] ?>" readonly>

                </div>

                <div class="col-md-1">

                    <label>Kullanılan İzin Süresi</label>
                    <br>

                    <input type="text" class="form-control" value="<?= $user['use_permit'] ?>" readonly>

                </div>
                <div class="col-md-1">

                    <label>Kalan İzin Hakkı</label>
                    <br>

                    <input type="text" class="form-control" value="<?= ($user['total_permit'] - $user['use_permit']) ?>" readonly>

                </div>



            </div>

        </div>

    </div>

</div>



<div class="row">

    <div class="col-sm-12">

        <div class="card-box table-responsive">

            <h3 class="m-t-0"><b>Son İzin Taleplerim</b></h3>

            <div class="table-responsive">

                <table id="lastest_permit_request" class="table table-striped table-bordered dataTable">

                    <thead>

                        <tr>

                            <th>İzin Türü</th>

                            <th>İzin Başlangıç Tarihi</th>

                            <th>İzin Bitiş Tarihi</th>

                            <th>Açıklama</th>

                            <th>Durum</th>

                            <th>Talep Tarihi</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        $waiting_badge = '<span class="label label-warning">Beklemede</span>';

                        $confirm_badge = '<span class="label label-success">Onaylandı</span>';

                        $not_confirm_badge = '<span class="label label-danger">Onaylanmadı</span>';



                        $sql = "SELECT permits.name, permits_request.permit_start_date, permits_request.permit_end_date, permits_request.description, permits_request.status, permits_request.created_at FROM permits_request INNER JOIN permits ON permits.id = permits_request.permit_id INNER JOIN users on users.id=permits_request.user_id WHERE users.id= '" . $_SESSION['id'] . "' AND users.status = 1 ORDER BY created_at DESC LIMIT 10";
// echo $sql;
                        $result = $conn->query($sql);

                        if (mysqli_num_rows($result) > 0) {

                            while ($val = $result->fetch_object()) {
                                if($val->status == 0) {
                                    $current_status = $not_confirm_badge;
                                }else if($val->status == 1) {
                                    $current_status = $waiting_badge;
                                }else {
                                    $current_status = $confirm_badge;
                                }

                                echo '<tr>

                                <td>' . $val->name . '</td>

                                <td>' . date_format(date_create($val->permit_start_date), "d-m-Y") . '</td>

                                <td>' . date_format(date_create($val->permit_end_date), "d-m-Y") . '</td>

                                <th>' . $val->description . '</th>

                                <th>' . $current_status . '</th>

                                <th>' . date_format(date_create($val->created_at), "d-m-Y") . '</th>

                            </tr>';
                            }
                        }
                        ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>