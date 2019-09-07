<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $coinsn;
    public $email;
    public $code_name;
    public $dateofjoining;
    public $profile_img;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }


public function validate(){
    if(empty($this->email)){
        return false;
    }

    if(empty($this->coinsn)){
        return false;
    }
    return true;
    // create product
}
function create(){
    // query to insert record
   /* $query = "INSERT INTO
                " . $this->table_name . "
            SET
                coinsn=:coinsn, email=:email, dateofjoining=:dateofjoining,username=:username";
    // prepare query
    // $stmt = $this->conn->prepare($query);
    */
    $this->dateofjoining = gmdate('Y-m-d h:i:s', time());
    // sanitize
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->coinsn=htmlspecialchars(strip_tags($this->coinsn));
    $this->code_name=rand(9,99999);
    $this->banned=0;
    $this->dateofjoining=htmlspecialchars(strip_tags($this->dateofjoining));
    //$this->username=htmlspecialchars(strip_tags($this->username));
    
    $sql = "INSERT INTO users (coinsn, email,code_name, banned, dateofjoining)
    VALUES ( " . $this->coinsn .",'". $this->email ."','".
     $this->code_name."','". $this->banned."','".$this->dateofjoining . "')" ;
    // execute query
    $result = $this->conn->query($sql);
    //echo $sql;
    if($result){
        return true;
    }
    return false;
     
}

function user_exist(){
    // select all query
     $query = "SELECT
                c.coinsn, c.email, c.dateofjoining
            FROM
                " . $this->table_name . " c
            where c.coinsn='".$this->coinsn."'";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
    return $stmt;
}

function user_duplicate(){
    // select all query
     $query = "SELECT
                c.coinsn, c.email, c.dateofjoining
            FROM
                " . $this->table_name . " c
            where email='".$this->email."' and coinsn !='".$this->coinsn."'";
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
    return $stmt;
}

function update(){
    // sanitize
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->coinsn=htmlspecialchars(strip_tags($this->coinsn));
    $sql = "UPDATE users SET email = '". $this->email ."' where coinsn='".$this->coinsn."'" ;
    //echo $sql;
    $result = $this->conn->query($sql);
    //echo $sql;
    if($result){
        return true;
    }
    return false;
    // read products
}

function upload(){
    $this->profile_img=htmlspecialchars(strip_tags($this->profile_img));
    $sql = "UPDATE users SET profile_img = '". $this->profile_img ."' where coinsn='".$this->coinsn."'" ;
    //echo $sql;
    $result = $this->conn->query($sql);
    //echo $sql;
    if($result){
        return true;
    }
    return false;
}



function read_sn(){
    // select all query
    $query = "SELECT
                c.coinsn,c.email as email,c.profile_img
            FROM
                " . $this->table_name . " c
            where c.coinsn ='". $this->coinsn."'";
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    return $stmt;
}


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

function file_upload(){
    
    $target_dir = "../../uploads/";
    $filename = $_FILES['profile_img'];
    $target_file = $target_dir . basename($_FILES["profile_img"]["name"]);
    $uploadOk = 0;
    if(!empty($_FILES["profile_img"]["name"])){
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $newFilename = "profile_".rand(9,99999999).".".$imageFileType;
     $target_file = $target_dir .$newFilename; 
    $check = getimagesize($_FILES["profile_img"]["tmp_name"]);
    $errorMessage ="";
     if($check !== false) {
        $uploadOk = 1;
        if ($_FILES["profile_img"]["size"] > 500000) {
            $errorMessage = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if (file_exists($target_file)) {

            $errorMessage = "Sorry, file already exists.";
            $uploadOk = 0;
        }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
            $errorMessage = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
             $errorMessage = "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
        } else {

        if (move_uploaded_file($_FILES["profile_img"]["tmp_name"], $target_file)) {
        $errorMessage = "File uploaded sucessfully.";
        } else {
        $errorMessage = "Sorry, there was an error uploading your file.";
        }
        }
     }
 }else{
    $newFilename = "";
    $errorMessage = "Please upload file.";
 }
     $fileStatus =array("status"=>$uploadOk,"message"=>$errorMessage,"filename"=>$newFilename);
     return $fileStatus;
    
}

}
?>