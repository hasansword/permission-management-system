<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <h3 class="m-t-0"><b>Onaylanmayan Listesi</b></h3>

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
                    <th>Red Nedeni</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT permits_request.id, permits_request.user_id, users_profile.name, bolum, permit_start_date,permit_end_date,created_at, description, deny_description, permits.name as permits_name FROM permits_request INNER JOIN users_profile ON users_profile.user_id = permits_request.user_id INNER JOIN bolumler on bolumler.id=users_profile.department INNER JOIN permits ON permits.id = permits_request.permit_id where permits_request.status=0 order by permits_request.id desc";
                $result = $conn->query( $sql );
                if ( mysqli_num_rows( $result ) > 0 ) {
                    while ( $val = $result->fetch_object() ) {
                        echo '<tr>
                                <td>' . $val->name . '</td>
								<th>' . $val->bolum . '</th>
                               <th>' . $val->permit_start_date . '</th>
							   <th>' . $val->permit_end_date . '</th>
							   <th>' . $val->created_at . '</th> 
							   <th>' . $val->permits_name . '</th> 
							   <th>' . $val->description . '</th> 
							   <th>' . $val->deny_description . '</th> 
                            </tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>