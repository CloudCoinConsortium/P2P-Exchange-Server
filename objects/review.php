<?php
class Review{
 
    // database connection and table name
    private $conn;
    private $table_name = "reviews";
 
    // object properties
    public $review_id;
    public $reviewee_sn;
    public $poster_sn;
    public $review_text;
    public $rating_in_starts;
    public $response_text;
    public $date_posted;
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

public function validate(){
    
    if(empty($this->review_text)){
        return false;
    }
     if(empty($this->rating_in_starts)){
        return false;
    }
    if($this->rating_in_starts<1 || $this->rating_in_starts>5){
        return false;
    }
    else{
        return true;
    }

}
    public function create(){
    $this->date_posted = gmdate('Y-m-d h:i:s', time());     
    $insertsql= "insert into ".$this->table_name." (review_id,reviewee_sn,poster_sn,review_text,rating_in_starts,date_posted) VALUES ('" . $this->review_id ."','" . $this->reviewee_sn ."','". $this->poster_sn."','" .$this->review_text."','". 
        $this->rating_in_starts."','". $this->date_posted ."')" ;
            $result = $this->conn->query($insertsql);
            if($result){
                return true;
            }
            else {
                return false;
            }
    }

    public function chkvalid(){
        $query = "Select * from ".$this->table_name." where reviewee_sn='".$this->reviewee_sn."' and poster_sn='".$this->poster_sn."'";
        //echo $query;
        $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    return $stmt;
    }

}