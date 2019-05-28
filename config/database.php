<?php
class Database{
 
    // specify your own database credentials
   /* private $host = "204.11.58.166";
    private $db_name = "navraggl_exchangecc";
    private $username = "exchangeprg";
    private $password = "54\$nM3mw";
    */

   private $host = "localhost";
    private $db_name = "store";
    private $username = "admin";
    private $password = "admin_password";

    public $conn;
 
    // get the database connection
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>