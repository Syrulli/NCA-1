<?php

class db {

    private $host = "localhost";
    private $uid = "root";
    private $pwd = "";
    private $dbName = "nca_db";

    public function connect(){
        $pdo = new PDO('mysql:host='.$this->host.'; dbname='.$this->dbName, $this->uid, $this->pwd);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}

?>