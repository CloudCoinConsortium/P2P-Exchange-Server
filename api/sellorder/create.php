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
include_once '../../objects/sellorder.php';
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

$authresponse = authenticate($ticket,$raida);

// echo json_decode( $authresponse);

if($authresponse["result"]) {
    
    $sellorder = new SellOrder($db);
    $sellorder->coinsn =$authresponse["sn"];
    $sellorder->qty=$qty;
    $sellorder->price=$price;
    $sellorder->currency = $currency;
    $sellorder->created = "";
    $sellorder->status = 1;
    $sellorder ->paymentmethod = $paymentmethod;

    if($sellorder->create()) {
        http_response_code(200);
    // show products data in json format
        echo json_encode(array("message" => "Created Sell Order Successfully"));
    }
    else {
        echo json_encode(array("message" => "Error Creating Sell Order"));
  
    }
}
else {
    http_response_code(401);
    // show products data in json format
    echo json_encode(array("message" => "Unauthorised Request"));
}

?>