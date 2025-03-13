<?php
include  'DBconfig.php';
class DB
{
public $db;
private $config;
function __construct()
{
    $this->config= new DBconfig();
    $this->db=new mysqli($this->config->host, $this->config->username, $this->config->password, $this->config->database);

    if ($this->db->connect_error) {
        die("Connection failed: " . $this->db->connect_error);
    }
}

function __destruct()
{
    $this->db->close();
}

public static function instance()
{
    return new DB();
}
public function execute($sql)
{
    $result=$this->db->query($sql);
    if(!$result){
      die("Error: $sql" . $this->db->error);
    }

    return $result;
}

public function close(){
    if($this->db){
        $this->db->close();
    }

}
}