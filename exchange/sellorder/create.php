<?php
// required headers
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// database connection will be here

// include database and object files
include_once '../database.php';
include_once 'sellorder.php';
include_once '../../objects/user.php';
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
$idSN = $_GET['sn'];
$UserURL = $_GET['url'];
$authresponse = authenticate($ticket,$raida,$idSN);

if($authresponse["result"]) {
    echo "successful authentication";
    $sellorder = new SellOrder($db);

    $sellorder->coinsn =$idSN;
 
    $sellorder->qty=$qty;
$sellorder->url=$UserURL;
    $sellorder->price=$price;
    $sellorder->currency = $currency;
    $sellorder->created = "";
    $sellorder->status = 1;
    $sellorder ->paymentmethod = $paymentmethod;

    if($sellorder->create()) {
        http_response_code(200);
        echo "success";
    // show products data in json format
        echo json_encode(array("message" => "Created Sell Order Successfully"));
    } 
    else {
        echo "fail";
        echo json_encode(array("message" => "Error Creating Sell Order"));
  
    }
}
else {
    http_response_code(401);
    // show products data in json format
    echo json_encode(array("message" => "Unauthorised Request"));
}

?>