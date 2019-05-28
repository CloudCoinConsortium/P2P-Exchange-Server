<?php
class Ads{
 
    // database connection and table name
    private $conn;
    private $table_name = "ads";
 
    // object properties
    public $ad_id;
    public $owner_user_sn;
    public $date_posted;
    public $top_catagory;
    public $sub_catagory;
    public $latitude;
    public $longitute;
    public $country;
    public $region_state;
    public $city;
    public $title;
    public $price;
    public $description;
    public $profile_img;
    public $prohibited;
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function validate(){
        if(empty($this->owner_user_sn)){
           return false;
        }
        if(empty($this->top_catagory)){
           return false ;
        }
        if(empty($this->sub_catagory)){
           return false;
        }
        if(empty($this->latitude)){
           return false;
        }
        if(empty($this->longitute)){
           return false;
        }
        if(empty($this->country)){
           return false;
        }
        if(empty($this->region_state)){
           return false;
        }
        if(empty($this->city)){
           return false;
        }

        if(empty($this->title)){
           return false;
        }

        return true;
    }
    function create(){
    // query to insert record
    $this->ad_id = $this->guid();
    // sanitize
    $this->owner_user_sn=htmlspecialchars(strip_tags($this->owner_user_sn));
    $this->date_posted=gmdate('Y-m-d h:i:s', time());
    $this->top_catagory=htmlspecialchars(strip_tags($this->top_catagory));
    $this->sub_catagory=htmlspecialchars(strip_tags($this->sub_catagory));
    $this->latitude=htmlspecialchars(strip_tags($this->latitude));
    $this->longitute=htmlspecialchars(strip_tags($this->longitute));
    $this->country=htmlspecialchars(strip_tags($this->country));
    $this->region_state=htmlspecialchars(strip_tags($this->region_state));
    $this->city=htmlspecialchars(strip_tags($this->city));
    $this->title=htmlspecialchars(strip_tags($this->title));
    $this->price=htmlspecialchars(strip_tags($this->price));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->prohibited=0;
     $sql = "INSERT INTO ads (owner_user_sn,date_posted, ad_id,top_catagory,sub_catagory, latitude, longitude,country,region_state,city,title,price,description,prohibited)
    VALUES ( " . $this->owner_user_sn .",'". $this->date_posted ."','". $this->ad_id ."','". $this->top_catagory ."','".
     $this->sub_catagory."','". $this->latitude."','".$this->longitute . "','".$this->country . "','".$this->region_state . "','".$this->city . "','".$this->title . "','".$this->price . "','".$this->description . "','".$this->prohibited . "')" ;
     $result = $this->conn->query($sql);
    if($result){
        return true;
    }
    return false;
}

function ad_exist(){
    // select all query
     $query = "SELECT
                c.ad_id
            FROM
                " . $this->table_name . " c
            where ad_id='".$this->ad_id."'";
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    return $stmt;
} 

public function update(){
    print_r($this);
    echo "Update func calling ..";
}

public function delete(){
    $query = "delete from ads  where ad_id= '".$this->ad_id."'";
     $stmt = $this->conn->prepare($query);
     $stmt->execute();
    return $stmt;
}

public function read_ad(){
    $query = "SELECT
                    c.ad_id,u.email as email, c.title, c.price, c.description, c.date_posted, c.description, c.top_catagory, c.sub_catagory,c.latitude, c.longitude,c.country,c.region_state, c.city, c.top_catagory,c.sub_catagory, c.latitude,c.longitude
                FROM
                    " . $this->table_name . " c,users u where c.owner_user_sn=u.coinsn and c.ad_id='". $this->ad_id."'";
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}
    function readAdsList($offset,$pageSize,$sn,$opt){
 
    // select all query
    
                if($opt== "all") {
                    $query = "SELECT
                    c.ad_id,u.email as email, c.title, c.price, c.description, c.date_posted, c.description, c.top_catagory, c.sub_catagory,c.latitude, c.longitude,c.country,c.region_state, c.city, c.top_catagory,c.sub_catagory, c.latitude,c.longitude
                FROM
                    " . $this->table_name . " c,users u where c.owner_user_sn=u.coinsn
                ORDER BY
                    c.date_posted DESC limit ". $offset . "," . $pageSize;
                }
                else {
                    $query = "SELECT
                    c.id,u.username as name, c.qty, c.price, c.currency, c.dateposted, c.paymentmethod
                FROM
                    " . $this->table_name . " c,users u where c.coinsn=u.coinsn and c.coinsn=". $sn."
                ORDER BY
                    c.dateposted DESC limit ". $offset . "," . $pageSize;

                    $query = "SELECT
                    c.ad_id,u.email as email, c.title, c.price, c.description, c.date_posted, c.description, c.top_catagory, c.sub_catagory,c.latitude, c.longitude,c.country,c.region_state, c.city, c.top_catagory,c.sub_catagory, c.latitude,c.longitude
                FROM
                    " . $this->table_name . " c,users u where c.owner_user_sn=u.coinsn and u.coinsn=". $sn."
                ORDER BY
                    c.date_posted DESC limit ". $offset . "," . $pageSize;
            
                }

               // echo $query;
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

function file_upload(){
    
    $target_dir = "../../uploads/ads/";
    $filename = $_FILES['ads_img'];
    $target_file = $target_dir . basename($_FILES["ads_img"]["name"]);
    $uploadOk = 0;
    if(!empty($_FILES["ads_img"]["name"])){
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $newFilename = "ads_".rand(9,99999999).".".$imageFileType;
     $target_file = $target_dir .$newFilename; 
    $check = getimagesize($_FILES["ads_img"]["tmp_name"]);
    $errorMessage ="";
     if($check !== false) {
        $uploadOk = 1;
        if ($_FILES["ads_img"]["size"] > 500000) {
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

        if (move_uploaded_file($_FILES["ads_img"]["tmp_name"], $target_file)) {
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
     print_r($fileStatus);
     return $fileStatus;
    
}

public function save_upload(){
     $query = "SELECT
                c.ad_id, c.images
            FROM
                " . $this->table_name . " c
            where ad_id='".$this->ad_id."'";
    // prepare query statement
            echo $query;
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_CLASS);
    if(!empty($result[0]->images)){
        $this->profile_img=$result[0]->images.",".$this->profile_img; 
    }

$sql = "UPDATE ". $this->table_name ." SET images='". $this->profile_img."' where 
        ad_id= '" . $this->ad_id ."'" ;
        echo $sql;
   $result = $this->conn->query($sql);
        if($result){
            return true;
        }
        return false;     
}

function guid(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);// "}"
        return $uuid;
    }
}
}
?>