<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <h3 class="m-t-0"><b>Onay Bekleyenlerin Listesi</b></h3>

            <hr>
            <p></p>
            <table id="user_table" class="table table-striped table-bordered dataTable">
                <thead>
                    <tr>
                        <th>Adı Soyadı</th>
                        <th>Bölüm Bilgisi</th>
                        <th>İzin Başlangıç</th>
                        <th>İzin Bitiş</th>
                        <th>Talep Tarihi</th>
                        <th>İzin Türü</th>
                        <th>Açıklama</th>
                        <th>Kalan İzin</th>
                        <th style="min-width: 50px; max-width: 50px;">İşlem</th>

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

                    $sql = "SELECT users.email as email, users_profile.*, bolum FROM users INNER JOIN users_profile ON users.id = users_profile.user_id INNER JOIN bolumler on bolumler.id=users_profile.department WHERE role = 2 AND users.status = 1 order by id desc";
                   
                    $result = $conn->query($sql);
                    
                    $user_array = array();
                    
                    if (mysqli_num_rows($result) > 0) {
                        while ($val = $result->fetch_object()) {
                            $fark = fark($val->start_work);
                            $izin = kullanilan_izin($val->user_id);
                            
                            $user_array[$val->user_id] = ($fark - $izin);
                         
                        }
                    }

                    ?>
                    
                    
                    
                    
                    <?php
                    

                    //$sql = "SELECT permits_request.id, permits_request.user_id, name, department, permit_start_date,permit_end_date,created_at, description FROM permits_request INNER JOIN users_profile ON users_profile.user_id = permits_request.user_id where permits_request.status=1 order by id desc";
                    $sql = "SELECT permits_request.id, permits_request.user_id, users_profile.name,start_work, bolum, permit_start_date,permit_end_date,created_at, description, permits.name as permits_name FROM permits_request INNER JOIN users_profile ON users_profile.user_id = permits_request.user_id INNER JOIN bolumler on bolumler.id=users_profile.department INNER JOIN permits ON permits.id = permits_request.permit_id where permits_request.status=1 order by permits_request.id desc";
                    $result = $conn->query($sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($val = $result->fetch_object()) {
                            echo '<tr>
                                <td>' . $val->name . '</td>
								<th>' . $val->bolum . '</th>
                               <th>' . $val->permit_start_date . '</th>
							   <th>' . $val->permit_end_date . '</th>
							   <th>' . $val->created_at . '</th> 
							   <th>' . $val->permits_name . '</th> 
							   <th>' . $val->description . '</th> 
                                                           <th>' . $user_array[$val->user_id] . '</th> 
                                <td><a href="?page=statusCheck1&id=' . $val->id . '"><i class="fa fa-check" style="color:blue;"> </i></a> &nbsp&nbsp <a class="deny_request" data-toggle="modal" data-target="#deny_request_modal" data-id="' . $val->id . '"> <i class="fa fa-times" style="color:red;"> </i></a></td>
                            </tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="deny_request_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deny_request_modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:55%;">
        <div class="modal-content">
            <form action="index.php?page=statusCheck0" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="deny_request_modalLabel">Red Nedeni</h4>
                </div>
                <div class="modal-body">
                    <textarea name="deny_content" id="" cols="50" rows="10"></textarea>
                    <input type="hidden" class="request_id" name="request_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light deny_request_btn">Gönder</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    $(document).on("click", ".deny_request", function () {
        $(".request_id").val($(this).data('id'));
    });
</script>