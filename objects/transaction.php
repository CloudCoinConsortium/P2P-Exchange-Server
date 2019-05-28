<?php
class Transaction{
 
    // database connection and table name
    private $conn;
    private $table_name = "transactions";
 
    // object properties
    public $id;
    public $coinsn;
    public $sellorderid;
    public $buyorderid;
    public $buyerid;
    public $sellerid;
    public $qty;
    public $rate;
    public $transactionno;
    public $recieptno;
    public $buyercomment;
    public $sellercomment;
    public $buyerrating;
    public $sellerrating;
    public $created;
    public $status;
    public $lastmodified;
    public $currency;
    public $paymentmethod;
    public $transactiondate;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products

function executeCountQuery($sql){
 
    $result=$this->conn->query($sql);
    //$data=$this->conn->mysql_fetch_assoc($result);
    //echo $result[0];

    $data = $result->fetch(PDO::FETCH_BOTH);
    //print_r($data);
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
     
        // prepare query
        // $stmt = $this->conn->prepare($query);
        
        $this->transactiondate = gmdate('Y-m-d h:i:s', time());
        // sanitize
        $this->coinsn=htmlspecialchars(strip_tags($this->coinsn));
        $this->sellerid=htmlspecialchars(strip_tags($this->sellerid));
        $this->buyerid=htmlspecialchars(strip_tags($this->buyerid));
        $this->transactiondate=htmlspecialchars(strip_tags($this->transactiondate));
        $this->transactionno=htmlspecialchars(strip_tags($this->transactionno));
        $this->recieptno=htmlspecialchars(strip_tags($this->recieptno));
        
        $this->buyercomment=htmlspecialchars(strip_tags($this->buyercomment));
        $this->sellercomment=htmlspecialchars(strip_tags($this->sellercomment));
        $this->buyerrating=htmlspecialchars(strip_tags($this->buyerrating));
        $this->sellerrating=htmlspecialchars(strip_tags($this->sellerrating));
        

        $this->qty=htmlspecialchars(strip_tags($this->qty));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->paymentmethod=htmlspecialchars(strip_tags($this->paymentmethod));
        $this->currency=htmlspecialchars(strip_tags($this->currency));
        $this->sellorderid=htmlspecialchars(strip_tags($this->sellorderid));
        $this->buyorderid=htmlspecialchars(strip_tags($this->buyorderid));
        
        
        $sql = "INSERT INTO transactions (sellorderid,buyorderid,buyerid,sellerid, qty, price,currency, 
        paymentmethod,transactiondate, buyerrating,sellerrating,buyercomment,sellercomment,transactionnumber,recieptnumber)
        VALUES ('" . $this->sellorderid ."','". $this->buyorderid."','" .$this->buyerid."','". 
        $this->sellerid ."','" . $this->qty ."','". $this->price ."','". $this->currency. "','". $this->paymentmethod. "','".
        $this->transactiondate ."','" . $this->buyerrating ."','". $this->sellerrating. "','".
        $this->buyercomment ."','" . $this->sellercomment ."','".$this->transactionno."','".$this->recieptno."')" ;
    
       //echo $sql;

       $countquery = "select count(*) as total from ". $this->table_name . " where coinsn=" . $this->coinsn ."";

       //$openSellOrderCount = $this->executeCountQuery($countquery);
       // $this->qty =0;
       if(!$this->validate()) {
        return false;
       }
    //    if($openSellOrderCount > 0) {
    //        return false;
    //    }

        $result = $this->conn->query($sql);
        if($result){
            return true;
        }
     
        return false;
         
    }

    function update(){
 
        $this->lastmodified = gmdate('Y-m-d h:i:s', time());
        // sanitize
        $this->coinsn=htmlspecialchars(strip_tags($this->coinsn));
        $this->qty=htmlspecialchars(strip_tags($this->qty));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->paymentmethod=htmlspecialchars(strip_tags($this->paymentmethod));
        $this->currency=htmlspecialchars(strip_tags($this->currency));
        
        
        $sql = "UPDATE ". $this->table_name ." SET qty=". $this->qty.", price=". $this->price .",currency='". $this->currency.
        "',paymentmethod='". $this->paymentmethod."',lastmodified='". $this->lastmodified."' where 
        id= " . $this->id ."" ;
    
       $countquery = "select count(*) as total from ". $this->table_name . " where coinsn=" . 
       $this->coinsn ." and id=". $this->id;

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
        
        
        $sql = "delete from ". $this->table_name."  where id= " . $this->id  ;
    
       
       $countquery = "select count(*) as total from ". $this->table_name . " where coinsn=" . 
       $this->coinsn ." and id=". $this->id;
       $openBuyOrderCount = $this->executeCountQuery($countquery);
       // $this->qty =0;
      
       if($openBuyOrderCount == 0) {
           return false;
       }

        $result = $this->conn->query($sql);
        if($result){
            return true;
        }
     
        return false;
         
    }

    function rate($rating,$comment,$id) {
        $buyercount = $this->executeCountQuery("select count(*) from transactions where buyerid=".$this->coinsn." and id=".$id);
        $sellercount = $this->executeCountQuery("select count(*) from transactions where sellerid=".$this->coinsn." and id=".$id);
        
        if($buyercount > 0) {
            $updatesql= "update transactions set buyerrating=".$rating.", buyercomment ='".$comment."' where id=".$id;
            $result = $this->conn->query($updatesql);
            if($result){
                return true;
            }
            else {
                return false;
            }
    
        }

        if($sellercount > 0) {
            $updatesql= "update transactions set sellerrating=".$rating.", sellercomment ='".$comment."' where id=".$id;
            $result = $this->conn->query($updatesql);
            if($result){
                return true;
            }
            else {
                return false;
            }
    
        }

        return false;
    }

   
    
    function getTransactions($offset,$pageSize,$sn,$opt){
 
    // select all query
    if($opt== "all") {
        $query = "SELECT
        a.id,b.username as seller, c.username as buyer, a.qty, a.price, a.currency, a.transactiondate, a.paymentmethod, 
        a.buyercomment,a.sellercomment, a.buyerrating,a.sellerrating
    FROM
        " . $this->table_name . " a,users b,users c where a.sellerid=b.coinsn and a.buyerid=c.coinsn
    ORDER BY
        a.transactiondate DESC limit ". $offset . "," . $pageSize;
    }
    else {
        $query = "SELECT
        a.id,b.username as seller, c.username as buyer, a.qty, a.price, a.currency, a.transactiondate, a.paymentmethod,
        a.buyercomment,a.sellercomment,a.buyerrating,a.sellerrating
    FROM
        " . $this->table_name . " a,users b, users c where a.sellerid=b.coinsn and a.buyerid=c.coinsn and (a.sellerid=". 
        $sn." or a.buyerid=". $sn .")
    ORDER BY
        a.transactiondate DESC limit ". $offset . "," . $pageSize;
    }
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

}
?>