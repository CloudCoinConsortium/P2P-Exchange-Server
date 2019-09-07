<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// database connection will be here

// include database and object files
include_once '../../config/database.php';
include_once '../../objects/ads.php';
//include_once '../../objects/user.php';
include_once '../../middleware/authenticate.php';
include_once '../../test.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$ticket= $_GET['ticket'];
$raida = $_GET['raida'];
$ads = new Ads($db);

$owner_user_sn = isset($_GET['owner_user_sn'])?$_GET['owner_user_sn']:"";
$top_catagory = isset($_GET['top_catagory'])?$_GET['top_catagory']:"";
$sub_catagory = isset($_GET['sub_catagory'])?$_GET['sub_catagory']:"";
$latitude = isset($_GET['latitude'])?$_GET['latitude']:"";
$longitute = isset($_GET['longitute'])?$_GET['longitute']:"";
$country = isset($_GET['country'])?$_GET['country']:"";
$region_state = isset($_GET['region_state'])?$_GET['region_state']:"";
$city = isset($_GET['city'])?$_GET['city']:"";
$title = isset($_GET['title'])?$_GET['title']:"";
$price = isset($_GET['price'])?$_GET['price']:"";
$description = isset($_GET['description'])?$_GET['description']:"";
$ad_id = isset($_GET['ad_id'])?$_GET['ad_id']:"";
$authresponse = authenticate($ticket,$raida);

if(!$authresponse["result"]) { //WN
    $coinssn = $authresponse["sn"];
    $owner_user_sn = (!empty($coinssn))?$coinssn:$owner_user_sn; //WN
if(!empty($ad_id)){
   $ads->ad_id=$ad_id;

   $chkExt = $ads->ad_exist();

   $chkCount = $chkExt->rowCount();
    $isNewUser = true;
    $dbresult = false;
    if($chkCount>0){

if(!empty($top_catagory)){$ads->top_catagory=$top_catagory;}
if(!empty($sub_catagory)){$ads->sub_catagory=$sub_catagory;}
if(!empty($latitude)){$ads->latitude=$latitude;}
if(!empty($longitute)){$ads->longitute=$longitute;}
if(!empty($country)){$ads->country=$country;}
if(!empty($region_state)){$ads->region_state=$region_state;}
if(!empty($city)){$ads->city=$city;}
if(!empty($title)){$ads->title=$title;}
if(!empty($price)){$ads->price=$price;}
if(!empty($description)){$ads->description=$description;}
if(!empty($city)){$ads->city=$city;}
    $dbresult =  $ads->update();
    }else{
       http_response_code(401);
    echo json_encode(array("message" => "Sorry, Ad not exist."));
    }
}else{
$ads->owner_user_sn=$owner_user_sn;
$ads->top_catagory=$top_catagory;
$ads->sub_catagory=$sub_catagory;
$ads->latitude=$latitude;
$ads->longitute=$longitute;
$ads->country=$country;
$ads->region_state=$region_state;
$ads->city=$city;
$ads->title=$title;
$ads->price=$price;
$ads->description=$description;
if($ads->validate()){
	    if($ads->create()) {
        http_response_code(200);
    // show products data in json format
        echo json_encode(array("message" => "Ad created Successfully."));
    } 
    else {
    	        http_response_code(401);
        echo json_encode(array("message" => "Error occured to create ad."));
  
    }
}else{
        http_response_code(401);
	 echo json_encode(array("message" => "Enter required fields."));
    //$sellorder->coinsn =$authresponse["sn"];
}

}
}
else {
    http_response_code(401);
    // show products data in json format
    echo json_encode(array("message" => "Unauthorised"));
}

?>