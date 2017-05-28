<?php
  class Config{
    private $dbo;

    function __construct() {
        $config = file_get_contents("./config.json");
        $config = json_decode($config);
        $this->dbo = new PDO('mysql:host=localhost;dbname=bicycles', $config->user, $config->pass);
        var_dump($this->dbo);
    }
    public function TakingCols() {
        $i=0;
        $cols = $this->dbo->query("SHOW COLUMNS FROM `realty`");
        $cols = $cols->fetchAll(PDO::FETCH_CLASS);
        $s = array();
        foreach ($cols as $key){
           $s += array(
             $key->Field => array(
               "FIELD_NAME" => $key->Field,
               "FIELD_TYPE" => $key->Type,
               "FIELD_ISNULL" => $key->Null,
               "FIELD_KEY" =>  $key->Key,
               "FIELD_DEFAULT_VALUE" => $key->Defaul,
               "FIELD_EXTRA" => $key->Extra
             )
           );

        }
        $s = json_encode($s,JSON_PRETTY_PRINT);
        file_put_contents('parserconfig.json',$s);
    }


  }
$hui = new Config;
$hui->TakingCols();
?>
