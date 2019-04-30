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
include_once '../../objects/buyorder.php';
include_once '../../middleware/authenticate.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();


$ticket= $_GET['ticket'];
$raida = $_GET['raida'];
$id= $_GET['id'];


$authresponse = authenticate($ticket,$raida);
//echo json_encode($ticket);


if($authresponse["result"]) {
    //echo json_encode('test');
    $coinsn=$authresponse["sn"];
    
    $buyorder = new BuyOrder($db);
    $buyorder->id=$id;
    $buyorder->coinsn = $coinsn;

    if($buyorder->delete()) {
        http_response_code(200);
    // show products data in json format
        echo json_encode(array("message" => "Deleted the Buy Order"));
    }
    else {
        http_response_code(401);
        echo json_encode(array("message" => "Error Deleting the Buy Order"));
    }
}
else {
    http_response_code(401);
 
    echo json_encode(array("message" => "Unauthorised."));

}

?>