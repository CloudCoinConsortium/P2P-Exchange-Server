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
include_once '../../objects/buyorder.php';
include_once '../../middleware/authenticate.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$ticket= $_GET['ticket'];
$raida = $_GET['raida'];

$qty = $_GET['qty'];
$price = $_GET['price'];
$currency = $_GET['currency'];
$paymentmethod =$_GET['paymentmethod'];
$id= $_GET['id'];


$authresponse = authenticate($ticket,$raida);

if($authresponse["result"]) {
    
    $coinsn=$authresponse["sn"];
    $buyorder = new BuyOrder($db);
    $buyorder->id=$id;
    $buyorder->coinsn =$coinsn;
    $buyorder->qty=$qty;
    $buyorder->price=$price;
    $buyorder->currency = $currency;
    $buyorder ->paymentmethod = $paymentmethod;

    if($buyorder->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Updated Buy Order successfully"));
    }
    else {
        http_response_code(401);
        echo json_encode(array("message" => "Error Updating Buy Order"));
    }
}
else {
    http_response_code(401);
 
    echo json_encode(array("message" => "Unauthorised."));

}

?>