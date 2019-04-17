<?php
class SellOrder{
 
    // database connection and table name
    private $conn;
    private $table_name = "sellorders";
 
    // object properties
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;
 
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

function readsql(){
 
    // select all query
    $query = "";
 
    // prepare query statement
    
    return $query;
}

function readSellOrders($offset,$pageSize){
 
    // select all query
    $query = "SELECT
                c.id,c.username as name, c.qty, c.price, c.currency, c.dateposted, c.paymentmethod
            FROM
                " . $this->table_name . " c
            ORDER BY
                c.dateposted DESC limit ". $offset . "," . $pageSize;
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

}