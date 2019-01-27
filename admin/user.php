<?php
include_once"sessionBilgi.php";
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <div class="row">
                <div class="col-sm-4">
                    <h3 class="m-t-0"><b>Kullanıcı Listesi</b></h3>
                    <a href="?page=useradd" class="btn btn-primary waves-effect w-md waves-light m-b-5">Yeni Kullanıcı Ekle</a>
                </div>
                <div class="col-sm-6" style="float:right" align="right">

                    <div  id="piechart"></div>
                </div>
            </div>
            <table id="user_table" class="table table-striped table-bordered dataTable">
                <thead>
                    <tr>
                        <th>Adı Soyadı</th>
                        <th>E-posta</th>
                        <th>Telefon</th>
                        <th>Personel Türü</th>
                        <th>İşe Başlangıç Tarihi</th>
                        <th>Kullandığı izin</th>
                        <th>Kalan izin hakkı</th>
                        <th>Bölüm Bilgisi</th>
                        <th style="min-width: 50px; max-width: 50px;">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    function fark($baslangic) {
                        $baslangic = date_format(date_create($baslangic), "d-m-Y");
                        $baslangic = strtotime($baslangic);
                        $bitis = strtotime(date("d-m-Y"));
                        $fark = ($bitis - $baslangic) / 86400;
                        $fark = $fark / 365;
                        $kidem = floor($fark) * 14;
                        return $kidem;
                    }

                    function kullanilan_izin($param) {
                        global $conn;
                        $sql = "SELECT SUM(permit_request_day) FROM permits_request WHERE user_id = " . $param . " and status=2";
                        $result = $conn->query($sql);
                        $izin = mysqli_fetch_array($result);
                        return $izin[0];
                    }
                    function izin_status($param){
                        global $conn;
                        $sql1="Select Count(Status) from permits_request where status=".$param;
                        $result2=$conn->query($sql1); 
                        $bekleyen = mysqli_fetch_array($result2);
                        return $bekleyen[0];
                    }
                    $sql = "SELECT users.email as email, users_profile.*, bolum FROM users INNER JOIN users_profile ON users.id = users_profile.user_id INNER JOIN bolumler on bolumler.id=users_profile.department WHERE role = 2 AND users.status = 1 order by id desc";
                   
                    $result = $conn->query($sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($val = $result->fetch_object()) {
                            $fark = fark($val->start_work);
                            $izin = kullanilan_izin($val->user_id);
                            echo '<tr>
                                <td>' . $val->name . '</td> 
                                <td>' . $val->email . '</td>
                                <td>' . $val->phone . '</td>
                                <th>' . (($val->type == 1) ? "İdari" : "Akademik") . '</th>
                                <th>' . date_format(date_create($val->start_work), "d-m-Y") . '</th>
                               <th>' . $izin . '</th>
                                <th>' . ($fark - $izin) . '</th>
                                <th>' . $val->bolum . '</th>
                                <td><a href="?page=update&id=' . $val->user_id . '"><i class="fa fa-pencil" style="color:blue;"> </i></a> &nbsp&nbsp <a data-id="'. $val->user_id .'" class="sa-warning"><i class="fa fa-trash-o" style="color:red;"> </i></a></td>
                            </tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>


<script type="text/javascript">

    $(document).on("click", ".sa-warning", function (e) {
        $(".confirm.btn.btn-lg.btn-warning").attr("data-id", $(this).data("id"))
    });

    $(document).on("click", ".confirm.btn.btn-lg", function () {
        window.location.href = "save.php?i=delete&id="+$(this).attr("data-id");
    });

// Load google charts
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Durum', 'Adet'],
            ['Onaylanan', <?php echo izin_status(2) ?>],
            ['Bekleyen', <?php echo izin_status(1) ?>],
            ['Reddedilen', <?php echo izin_status(0) ?>],
        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title': 'Liste', 'width': 400, 'height': 180};

        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
</script>