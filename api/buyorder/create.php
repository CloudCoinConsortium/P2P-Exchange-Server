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
include_once '../../objects/user.php';
include_once '../../middleware/authenticate.php';
include_once '../../test.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$ticket= $_GET['ticket'];
$raida = $_GET['raida'];
$qty = $_GET['qty'];
$price = $_GET['price'];
$currency = $_GET['currency'];
$paymentmethod =$_GET['paymentmethod'];

$authresponse = authenticate( $ticket,$raida);
//echo json_encode($ticket);
echo json_encode($authresponse);

if($authresponse["result"]) {
    //echo json_encode('test');
    
    $buyorder = new BuyOrder($db);
    $buyorder->coinsn =$authresponse["sn"];
    $buyorder->qty=$qty;
    $buyorder->price=$price;
    $buyorder->currency = $currency;
    $buyorder->created = "";
    $buyorder->status = 1;
    $buyorder->paymentmethod = $paymentmethod;

    if($buyorder->create()) {
        http_response_code(200);
    // show products data in json format
        echo json_encode("Added New Buy Order ");
    }
    else {
        http_response_code(403);
        echo json_encode("Error Creating Buy Order.");
  
    }
}
else {
    http_response_code(401);
    // show products data in json format
    echo json_encode("Unauthorised");

}

?>