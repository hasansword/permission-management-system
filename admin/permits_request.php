<?php
include_once"sessionBilgi.php";
?>

<div class="row">

    <div class="col-sm-12">

        <div class="card-box table-responsive">

            <h3 class="m-t-0"><b>Bekleyen İzin Taleplerim</b></h3>

            <div class="table-responsive">

                <table id="waiting_permit_request" class="table table-striped table-bordered dataTable">

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
                        $sql = "SELECT permits.name, permits_request.permit_start_date, permits_request.permit_end_date, permits_request.description, permits_request.status, permits_request.created_at FROM permits_request INNER JOIN permits ON permits.id = permits_request.permit_id INNER JOIN users on users.id=permits_request.user_id WHERE users.id= '" . $_SESSION['id'] . "' and permits_request.status=1 ORDER BY created_at DESC LIMIT 10";

                        $result = $conn->query($sql);

                        if (mysqli_num_rows($result) > 0) {

                            while ($val = $result->fetch_object()) {

                                echo '<tr>

                                <td>' . $val->name . '</td>

                                <td>' . date_format(date_create($val->permit_start_date), "d-m-Y") . '</td>

                                <td>' . date_format(date_create($val->permit_end_date), "d-m-Y") . '</td>

                                <th>' . $val->description . '</th>

                                <th><span class="label label-warning">Beklemede</span></th>

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

<div class="row">

    <div class="col-sm-12">

        <div class="card-box table-responsive">

            <h3 class="m-t-0"><b>Onaylanan İzin Taleplerim</b></h3>

            <div class="table-responsive">

                <table id="confirm_permit_request" class="table table-striped table-bordered dataTable">

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
                        $sql = "SELECT permits.name, permits_request.permit_start_date, permits_request.permit_end_date, permits_request.description, permits_request.status, permits_request.created_at FROM permits_request INNER JOIN permits ON permits.id = permits_request.permit_id INNER JOIN users on users.id=permits_request.user_id WHERE users.id= '" . $_SESSION['id'] . "' and permits_request.status=2 ORDER BY created_at DESC LIMIT 10";

                        $result = $conn->query($sql);

                        if (mysqli_num_rows($result) > 0) {

                            while ($val = $result->fetch_object()) {

                                echo '<tr>

                                <td>' . $val->name . '</td>

                                <td>' . date_format(date_create($val->permit_start_date), "d-m-Y") . '</td>

                                <td>' . date_format(date_create($val->permit_end_date), "d-m-Y") . '</td>

                                <th>' . $val->description . '</th>

                                <th><span class="label label-success">Onaylandı</span></th>

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

<div class="row">

    <div class="col-sm-12">

        <div class="card-box table-responsive">

            <h3 class="m-t-0"><b>Onaylanmayan İzin Taleplerim</b></h3>

            <div class="table-responsive">

                <table id="not_confirm_permit_request" class="table table-striped table-bordered dataTable">

                    <thead>

                        <tr>

                            <th>İzin Türü</th>

                            <th>İzin Başlangıç Tarihi</th>

                            <th>İzin Bitiş Tarihi</th>

                            <th>Açıklama</th>

                            <th>Red Sebebi</th>

                            <th>Durum</th>

                            <th>Talep Tarihi</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        $sql = "SELECT permits.name, permits_request.permit_start_date, permits_request.permit_end_date, permits_request.description, permits_request.deny_description, permits_request.status, permits_request.created_at FROM permits_request INNER JOIN permits ON permits.id = permits_request.permit_id INNER JOIN users on users.id=permits_request.user_id WHERE users.id= '" . $_SESSION['id'] . "' and permits_request.status=0 ORDER BY created_at DESC LIMIT 10";

                        $result = $conn->query($sql);

                        if (mysqli_num_rows($result) > 0) {

                            while ($val = $result->fetch_object()) {

                                echo '<tr>

                                <td>' . $val->name . '</td>

                                <td>' . date_format(date_create($val->permit_start_date), "d-m-Y") . '</td>

                                <td>' . date_format(date_create($val->permit_end_date), "d-m-Y") . '</td>

                                <th>' . $val->description . '</th>
                                
                                <th>' . (($val->deny_description != NULL)? $val->deny_description : "Belirtilmemiş" ) . '</th>

                                <th><span class="label label-danger">Onaylanmadı</span></th>

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