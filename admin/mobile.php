<?php

header("Access-Control-Allow-Origin: *");
class API{
        private $conn=NULL;
    	const hostname="94.73.172.6";
	const username="hasan4k_izintakp";//local kullanıcı adım
	const pass="Hasanklc56.";//local şifrem.
	const db="hasan4k_izintakip";//veritabanı adım
	public $data;
        public function __construct(){//nesne oluştuğu anda ilk çalışan metod
		$this->dbconnect();//database bağlantısını program ilk çalıştırıldığında yapmasını istedik.
	}
	private function dbconnect(){
		$this->conn=new mysqli(self::hostname,self::username,self::pass,self::db);
		if($this->conn->connect_error){
			die("hata var");
		}
		$this->conn->set_charset("utf8");
	}
        public function login($username,$sifre){
            $sql="select * from users where email='".$username."' and password='".$sifre."'";
            $result=$this->conn->query($sql);
            if($result->num_rows>0){
                while($rs=mysqli_fetch_object($result)){
                    
                    echo $_POST[$rs->id];
                    echo $rs->id;
                }
                
            }
            else{
                echo "HATA!";
            }
	}

 	public function getData($param){
		if($param=="all"){
			$komut="select * from users order by id desc";
		}else {
			$komut="SELECT permits_request.id as veriID, permits.*, users.*, permits_request.* FROM permits_request INNER JOIN permits ON permits.id = permits_request.permit_id INNER JOIN users on users.id=permits_request.user_id WHERE permits_request.user_id='".$param."'";
		}
                
		$result=$this->conn->query($komut);
		if($result->num_rows>0){
			while($rs=$result->fetch_object()){//rs=record set veri kümesi diyebiliriz..
                            $data["veriler"]["v".$rs->veriID]["name"]=$rs->id;
				$data["veriler"]["v".$rs->veriID]["name"]=$rs->name;
				//Amaç json formatında yazmak. id si 1 olanın  baslıgı nedir? dediğimiz için atama yaptık.
                                $data["veriler"]["v".$rs->veriID]["status"]=$rs->status;
				$data["veriler"]["v".$rs->veriID]["description"]=$rs->description;
                                $data["veriler"]["v".$rs->veriID]["permit_start_date"]=$rs->permit_start_date;
                                $data["veriler"]["v".$rs->veriID]["permit_end_date"]=$rs->permit_end_date;
                                $data["veriler"]["v".$rs->veriID]["created_at"]=$rs->created_at;
				
                           
                             
			}
		}else{
			//kayıt yok
			$data["hata"]=1;
		}
                       echo $this->JSON($data);
                       
                
	
		
	}
        private function JSON($veri){
		if(is_array($veri)){
			return json_encode($veri);//veriyi json türünde şifreler
			//decode ise json türünde gelen veriyi diziye çevirir kullanmamızı sağlar.
		}
	}
    
}
$nesne=new API();//api classından bi nesne oluşturduk.
	if($_SERVER["REQUEST_METHOD"]=="GET"){//get request çalıştıysa aşağıdaki işlemi yap
             
		if(isset($_GET["islem"])){
			$nesne->delData($_GET["id"]);
		}else{
			echo $nesne->getData($_GET["param"]);//get data deyip veriyi çağırıyoruz.
                        
		}
	}else if($_SERVER["REQUEST_METHOD"]=="POST"){
		$nesne->login($_POST["email"],$_POST["password"]);

	}

?>