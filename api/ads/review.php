<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// database connection will be here

// include database and object files
include_once '../../config/database.php';
include_once '../../objects/review.php';
include_once '../../objects/ads.php';
include_once '../../middleware/authenticate.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$ticket= $_GET['ticket'];
$raida = $_GET['raida'];

$ad_id = $_GET['ad_id'];
$rating = $_GET['rating'];
$comment = $_GET['comment'];

$authresponse = authenticate($ticket,$raida);
//echo json_encode($authresponse);

if(!$authresponse["result"]) {//WN
    $review = new Review($db);
    $ads = new Ads($db);
    $review->poster_sn= $ad_id;
    $review->review_text=$comment;
    $review->rating_in_starts=$rating;
    $review->reviewee_sn = $authresponse["sn"];
    $review->reviewee_sn = "666666";

    $review->review_id = $ads->guid();
    if($review->validate()){
        $ads->ad_id = $ad_id;
        $chkadExt = $ads->ad_exist();
        $chkadCount = $chkadExt->rowCount();
    if($chkadCount>0){
    $chkExt = $review->chkvalid();
    $chkCount = $chkExt->rowCount();
        if($chkCount<1){
         $result = $review->create();
}else{
   $message = "already rated.";
}
     
    }else{
         $message = "Ad no longer exist.";
        
    }
    }else{
        $message = "Invalid request.";
    }
    
    if($result) {
        http_response_code(200);
        // show products data in json format
        echo json_encode(array("message" => "Rated Successfully."));

    }
    else {
        http_response_code(401);
    // show products data in json format
        echo json_encode(array("message" => $message));

    }
}
else {
    http_response_code(404);
    // show products data in json format
        echo json_encode(array("message" => "Unauthorised review"));
}
?>