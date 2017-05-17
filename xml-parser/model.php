<?php
  class XMLdoc(){
  	private $xmlFile;
  	private $dbo;
  	private $user = "root";
  	private $pass = "L3zctxfg!";
  	private function DBConnect() {
  		try {
  			$dbo = new PDO('mysql:host=localhost;dbname=realty',$user,$pass);
  		}
  		catch (PDOException $e) {
		    echo "Error!: " . $e->getMessage() . "<br/>";
		    die();
		}

  	}
    public function Load($path){
    	$xmlFile = simplexml_load_file($path);
    }
    public function Validate(){

    }
    public function Compare(){
    	
    }
    public function Cache(){}
    public function WriteInDB(){}

  }
?>
