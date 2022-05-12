<?php
require_once "modeles/database.php";

class Regions extends Database
{
    public function getRegions(){
        //la connexion
        $db = $this->getPDO();
        $sql = "SELECT * FROM departement";
        $regions = $db->query($sql);
        return $regions;
    }

}



