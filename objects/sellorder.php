<?php
class SellOrder{
 
    // database connection and table name
    private $conn;
    private $table_name = "sellorders";
 
    // object properties
    public $id;
    public $coinsn;
    public $currency;
    public $price;
    public $paymentmethod;
    public $qty;
    public $created;
    public $status;
    public $lastmodified;
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
function read(){
 
    // select all query
    $query = "SELECT
                c.id,c.username as username, c.qty, c.price, c.currency, c.dateposted, c.paymentmethod
            FROM
                " . $this->table_name . " c
            ORDER BY
                c.dateposted DESC limit 2,10";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

function executeCountQuery($sql){
 
    $result=$this->conn->query($sql);
    //$data=$this->conn->mysql_fetch_assoc($result);
    //echo $result[0];

    $data = $result->fetch(PDO::FETCH_BOTH);
    // print_r($data);
    return $data[0];
}

function validate() {
    if($this->qty<=0) {
        return false;
    }
    if($this->price<=0) {
        return false;
    }
    if($this->currency=="") {
        return false;
    }
    if($this->paymentmethod=="") {
        return false;
    }
    return true;
}
    // create product
    function create(){
 
        
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    coinsn=:coinsn, email=:email, dateofjoining=:dateofjoining,username=:username";
     
        // prepare query
        // $stmt = $this->conn->prepare($query);
        
        $this->dateposted = gmdate('Y-m-d h:i:s', time());
        // sanitize
        $this->coinsn=htmlspecialchars(strip_tags($this->coinsn));
        $this->qty=htmlspecialchars(strip_tags($this->qty));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->paymentmethod=htmlspecialchars(strip_tags($this->paymentmethod));
        $this->currency=htmlspecialchars(strip_tags($this->currency));
        
        
        $sql = "INSERT INTO sellorders (coinsn, qty, price,currency, dateposted,paymentmethod,status,lastmodified)
        VALUES ( " . $this->coinsn .",'". $this->qty ."','". $this->price ."','". $this->currency. "','".
         $this->dateposted. "','". $this->paymentmethod . "',1,'". $this->dateposted ."')" ;
    
       //echo $sql;

       $countquery = "select count(*) as total from ". $this->table_name . " where coinsn=" . $this->coinsn ." and status=1";

       $openSellOrderCount = $this->executeCountQuery($countquery);
       // $this->qty =0;
       if(!$this->validate()) {
        return false;
       }
       if($openSellOrderCount > 0) {
           return false;
       }

        $result = $this->conn->query($sql);
        if($result){
            return true;
        }
     
        return false;
         
    }

    function update(){
 
        
       
        // prepare query
        // $stmt = $this->conn->prepare($query);
        
        $this->lastmodified = gmdate('Y-m-d h:i:s', time());
        // sanitize
        $this->coinsn=htmlspecialchars(strip_tags($this->coinsn));
        $this->qty=htmlspecialchars(strip_tags($this->qty));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->paymentmethod=htmlspecialchars(strip_tags($this->paymentmethod));
        $this->currency=htmlspecialchars(strip_tags($this->currency));
        
        
        $sql = "UPDATE sellorders SET qty=". $this->qty.", price=". $this->price .",currency='". $this->currency.
        "',paymentmethod='". $this->paymentmethod."',lastmodified='". $this->lastmodified."' where 
        id= " . $this->id ."" ;
    
       // echo $sql;

       $countquery = "select count(*) as total from ". $this->table_name . " where coinsn=" . 
       $this->coinsn ." and status=1 and id=". $this->id;

       $openSellOrderCount = $this->executeCountQuery($countquery);
       // $this->qty =0;
       if(!$this->validate()) {
        return false;
       }
       if($openSellOrderCount == 0) {
           return false;
       }

        $result = $this->conn->query($sql);
        if($result){
            return true;
        }
     
        return false;
         
    }

    function delete(){
 
        
       
        // prepare query
        // $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->coinsn=htmlspecialchars(strip_tags($this->coinsn));
        $this->id=htmlspecialchars(strip_tags($this->id));
        
        
        $sql = "delete from sellorders  where id= " . $this->id  ;
    
       // echo $sql;

       $countquery = "select count(*) as total from ". $this->table_name . " where coinsn=" . 
       $this->coinsn ." and status=1 and id=". $this->id;
      //  echo $countquery;
       $openSellOrderCount = $this->executeCountQuery($countquery);
       // $this->qty =0;
       
       if($openSellOrderCount == 0) {
           return false;
       }

        $result = $this->conn->query($sql);
        if($result){
            return true;
        }
     
        return false;
         
    }

    
function readSellOrders($offset,$pageSize,$sn,$opt){
 
    // select all query
    
                if($opt== "all") {
                    $query = "SELECT
                    c.id,u.username as name, c.qty, c.price, c.currency, c.dateposted, c.paymentmethod
                FROM
                    " . $this->table_name . " c,users u where c.coinsn=u.coinsn
                ORDER BY
                    c.dateposted DESC limit ". $offset . "," . $pageSize;
                }
                else {
                    $query = "SELECT
                    c.id,u.username as name, c.qty, c.price, c.currency, c.dateposted, c.paymentmethod
                FROM
                    " . $this->table_name . " c,users u where c.coinsn=u.coinsn and c.coinsn=". $sn."
                ORDER BY
                    c.dateposted DESC limit ". $offset . "," . $pageSize;
            
                }
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

}
?>