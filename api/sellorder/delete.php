<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// database connection will be here

// include database and object files
include_once '../../config/database.php';
include_once '../../objects/sellorder.php';
include_once '../../objects/user.php';
include_once '../../middleware/authenticate.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$ticket= $_GET['ticket'];
$raida = $_GET['raida'];
$id= $_GET['id'];

$authresponse = authenticate($ticket,$raida);


if($authresponse["result"]) {
    //echo json_encode('test');
    
    $sellorder = new SellOrder($db);
    $sellorder->id=$id;
    $sellorder->coinsn =$authresponse["sn"];
    
    if($sellorder->delete()) {
        http_response_code(200);
    // show products data in json format
        echo json_encode(array("message" => "Deleted the Sell Order"));
    }
    else {
        http_response_code(401);
        echo json_encode(array("message" => "Error deleting Sell Order"));
    }
}
else {
    http_response_code(401);
 
    echo json_encode(array("message" => "Unauthorised Request"));

}

?>