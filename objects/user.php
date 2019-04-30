<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $coinsn;
    public $username;
    public $email;
    public $dateofjoining;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // create product
function create(){
 
    // echo json_encode("here");
    
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                coinsn=:coinsn, email=:email, dateofjoining=:dateofjoining,username=:username";
 
    // prepare query
    // $stmt = $this->conn->prepare($query);
    
    $this->dateofjoining = gmdate('Y-m-d h:i:s', time());
    // sanitize
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->coinsn=htmlspecialchars(strip_tags($this->coinsn));
    $this->dateofjoining=htmlspecialchars(strip_tags($this->dateofjoining));
    $this->username=htmlspecialchars(strip_tags($this->username));
    
    $sql = "INSERT INTO users (coinsn, username, email,dateofjoining)
    VALUES ( " . $this->coinsn .",'". $this->username ."','". $this->email ."','". $this->dateofjoining . "')" ;

echo $sql;
    // echo $sql;
    // if (mysqli_query($conn, $sql)) {
    //     echo "New record created successfully";
    // } else {
    //     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    // }
    // // bind values
    // $stmt->bindValue(":coinsn", $this->coinsn,PDO::PARAM_STR);
    // $stmt->bindValue(":email", $this->email, PDO::PARAM_STR);
    // $stmt->bindValue(":dateofjoining", $this->dateofjoining, PDO::PARAM_STR);
    // $stmt->bindValue(":username", $this->username, PDO::PARAM_STR);
    
    // echo json_encode($stmt);
    
    // execute query
    $result = $this->conn->query($sql);
    //echo $result;
    if($result){
        return true;
    }
 
    return false;
     
}
    // read products
function read(){
 
    // select all query
    $query = "SELECT
                c.coinsn,c.username as username, c.email, c.dateofjoining
            FROM
                " . $this->table_name . " c
            ORDER BY
                c.dateofjoining ";
 
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
                c.coinsn,c.username as name, c.email, c.dateofjoining
                            FROM
                " . $this->table_name . " c
            ORDER BY
                c.dateofjoining DESC limit ". $offset . "," . $pageSize;
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

}
?>