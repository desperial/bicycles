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
    	$objects = $dbo->query("SELECT * FROM `realty` WHERE")->fetchAll();
    	foreach ($objects as $object):
    	endforeach;
    }
    public function Cache(){}
    public function WriteInDB(){}

  }
?>
