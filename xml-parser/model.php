<?php
  class XMLdoc {
    public $xmlFile;
    private $dbo;
    private $user = "root";
    private $pass = "L3zctxfg!";
    private $items4Delete = array();
    public $partners;

    function __construct() {
        $this->dbo = new PDO('mysql:host=localhost;dbname=bicycles',$this->user,$this->pass);
    }
    public function Load($path){
        $this->xmlFile = simplexml_load_file($path);
    }
    public function getPartners() {
        return $this->dbo->query("SELECT * FROM `partner_links` LEFT JOIN `partners` ON `partner_links`.partner_id = `partners`.`id`")->fetchAll(PDO::FETCH_CLASS);
    }
    private function clearXmlItem() {
        foreach ($this->items4Delete as $item)
            unset($item[0]);
        $this->items4Delete = array();
    }
    public function Validate(){
        foreach ($this->xmlFile->object as $file_object):
            $check = true;
            $check = preg_match("/^\d{1,11}$/",$file_object->id) ? $check : false;
            $check = preg_match("/^\w{2}$/",$file_object->country) ? $check : false;
            $check = preg_match("/^\w{2,3}$/",$file_object->currency) ? $check : false;
            $check = preg_match("/^\d{1,11}$/",$file_object->price) ? $check : false;
            $check = preg_match("/^\d{1,6}[\,\.]?\d?$/",$file_object->area) ? $check : false;
            $check = preg_match("/^(rent|buy)$/",$file_object->deal) ? $check : false;
            $check = preg_match("/^(residental|commercial)$/",$file_object->type) ? $check : false;
            $check = preg_match("/^(house|building|land|investment|apartment|premises|others|townhouse)$/",$file_object->subtype) ? $check : false;
            $check = preg_match("/^(primary|secondary)$/",$file_object->grp) ? $check : false;
            $check = preg_match("/^\d{1,10}[\,\.]?\d{1,14}?$/",$file_object->lat) ? $check : false;
            $check = preg_match("/^\d{1,11}[\,\.]?\d{1,14}?$/",$file_object->longt) ? $check : false;
            $check = preg_match("/^.{0,255}$/",$file_object->adress) ? $check : false;

            if (!$check)
                $this->items4Delete[] = $file_object;
            else {
                $file_object->adress = $this->dbo->quote($file_object->adress);
            }
        endforeach;
        $this->clearXmlItem();
    }
    public function Compare($partner){
        $objects = $this->dbo->query("SELECT * FROM `realty` WHERE `realty`.`partner_id` = ".$partner);
        if ($objects) :
            $objects = $objects->fetchAll(PDO::FETCH_CLASS);
            foreach ($objects as $object):
                foreach ($this->xmlFile->object as $file_object):
                    if ($file_object->id == $object->object_id):
                        if (($file_object->price != $object->price) || ($file_object->deal != $object->deal) //Проверка на совпадения в выборке
                            || ($file_object->currency != $object->currency) || ($file_object->country != $object->country)
                            || ($file_object->area != $object->area) || ($file_object->type != $object->type)
                            || ($file_object->subtype != $object->subtype) || ($file_object->grp != $object->grp)
                            || ($file_object->lat != $object->lat) || ($file_object->longt != $object->longt)
                            || ($file_object->adress != $object->adress))
                            $file_object[0]->addChild("edited", "1"); //Если совпадение частичное - ставим пометку "отредактировано"
                        else {
                            $this->items4Delete[] = $file_object;
                            // unset($file_object[0]); //Если совпадение полное - убираем из выборки
                            break;
                        }
                    endif;
                endforeach;
            endforeach;
            $this->clearXmlItem();
        endif;
    }
    public function Cache(){}
    public function WriteInDB($partner){
        $query = "";
        $query_add = Array();
        $query_update = Array();
        foreach ($this->xmlFile->object as $file_object) :
            if (isset($file_object->edited) && ($file_object->edited == 1)) : //Если с пометкой "отредактировано - собираем в запрос на UPDATE"
                $query_update[] = "UPDATE realty SET country = '".$file_object->country."', `currency` = '".$file_object->currency."', ".
                    "price = ".$file_object->price.", area = ".$file_object->area.", deal = '".$file_object->deal."', ".
                    "type = '".$file_object->type."', subtype = '".$file_object->subtype."', grp = '".$file_object->grp."', ".
                    "lat = ".$file_object->lat.", longt = ".$file_object->longt.", adress = '".$file_object->adress."' ".
                    "WHERE object_id = ".$file_object->id." AND partner_id = ".$partner; 
            else:
                $query_add[] = "(".$file_object->id.",".$partner.",'".$file_object->country."','".$file_object->currency."',".
                $file_object->price.",".$file_object->area.",'".$file_object->deal."','".$file_object->type."','".$file_object->subtype."','".
                $file_object->grp."',".$file_object->lat.",".$file_object->longt.",".$file_object->adress.")";
            endif;
        endforeach;

        if ($query_add) :
            $query = "INSERT INTO realty (object_id,partner_id,country,currency,price,area,deal,type,subtype,grp,lat,longt,adress) VALUES ";
            $query .= implode(",",$query_add);
            $this->dbo->query($query);
        endif;
        if ($query_update) :
            $query = implode(";",$query_update);
            $this->dbo->query($query);
        endif;
        // $this->dbo = null;
    }

  }



?>
