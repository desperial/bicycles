<?php
  class XMLdoc {
  	public $xmlFile;
  	private $dbo;
  	private $user = "root";
  	private $pass = "L3zctxfg!";
  	public function DBConnect() {
		$this->dbo = new PDO('mysql:host=localhost;dbname=bicycles',$this->user,$this->pass);
  	}
    public function Load($path){
		$this->xmlFile = simplexml_load_file($path);
    }
    public function Validate(){

    }
    public function Compare($partner){
    	$objects = $this->dbo->query("SELECT * FROM `realty` WHERE `realty`.`partner_id` = ".$partner)->fetchAll(PDO::FETCH_CLASS);
    	foreach ($objects as $object):
    		foreach ($this->xmlFile->object as $key=>$file_object):
    			if ($file_object->id == $object->id):
    				if (($file_object->price != $object->price) || ($file_object->deal != $object->deal) 
    					|| ($file_object->currency != $object->currency))
    					$this->xmlFile->object[$key]->addChild("edited", "1");
    				else {
    					unset($file_object[0]);
    					break;
    				}
    			endif;
    		endforeach;
    	endforeach;
    }
    public function Cache(){}
    public function WriteInDB(){}

  }

  $test = new XMLdoc();
  $test->DBConnect();
  $test->Load("test.xml");
  $test->Compare("1");
  print_r($test->xmlFile);
?>
