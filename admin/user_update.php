 <?php
include "../inc/connection.php";



/*
?>


<div class="row">
    <div class="col-xs-12">
        <div class="card-box">
            <div class="row">
                <div class="col-sm-12 col-xs-12 col-md-6">
                    <h4 class="header-title m-t-0">Kullanıcı Kayıt Formu</h4>
                    <p class="text-muted font-13 m-b-10">

                    </p>

                    <div class="p-20">
                        <form role="form" data-parsley-validate novalidate action="save.php?i=user_update&id=<?php echo $_GET["id"]?>" method="post">
                            <?php
                                if(isset($_GET[i])){
                            ?>
                            <div class="alert alert-success">
                                <strong>BİLGİ:</strong>Kayıt Güncellendi
                             </div>  
                            <?php
                            }
                                $sql="SELECT * FROM users INNER JOIN users_profile ON users.id = users_profile.user_id WHERE users.status = 1 AND user_id=".$_GET["id"];
                                $result=$conn->query($sql);
                                if($result->num_rows>0){
                                        $rs=$result->fetch_object();
                                }else{
                                    $header = header("Location:index.php");
                                }
?>
                           
                            <div class="form-group row">
                                <label for="nameSurname" class="col-sm-4 form-control-label">Ad Soyad<span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <input type="text-danger" required parsley-type="text-danger" class="form-control"  id="nameSurname" name="nameSurname" placeholder="Ad,Soyad" value="<?php echo $rs->name ?>"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 form-control-label">E-posta<span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <input type="email" required parsley-type="email" class="form-control" id="email" name="email" placeholder="E-posta"value="<?php echo $rs->email ?>"/>
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
                                    <input type="tel" required parsley-type="text-danger" class="form-control" id="phone" name="phone" data-mask="(999) 999-9999" placeholder="Telefon" value="<?php echo $rs->phone ?>"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="personelTuru" class="col-sm-4 form-control-label">Personel Türü<span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <select name="userType" id="userType" class="form-control" required parsley-type="text-danger">
                                        <option value="<?php echo $rs->type ?>">İdari</option>
                                        <option value="<?php echo $rs->type ?>">Akademik</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="iseBaslangic" class="col-sm-4 form-control-label">İşe Başlangıç Tarihi<span class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control date_picker" id="start_work" name="start_work" placeholder="GG-AA-YYYY" value="<?php echo $rs->start_work ?>">
                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bolumBilgisi" class="col-sm-4 form-control-label">Bölüm Bilgisi<span class="text-danger">*</span></label>
                                <div class="col-sm-7">

                                    <select class="form-control" name="bolumBilgisi" onchange="formKontrol()" id="bolumBilgisi">
                                        <option>Seçiniz</option>
                                        <?php
                                        $list = "SELECT * FROM bolumler order by bolum asc";
                                        $result = $conn->query($list);
                                        while ($row = mysqli_fetch_array($result)) {

                                            echo "<option  value='" . $row["id"] . "'>" . $row["bolum"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-8 col-sm-offset-4">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="saveUser">
                                        Güncelle
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
 