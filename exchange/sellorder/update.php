<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);

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
$idSN= $_GET['sn'];
$id=$_GET['id'];

$authresponse = authenticate($ticket,$raida,$idSN);
//echo json_encode($ticket);

if($authresponse["result"]) {
    //echo json_encode('test');

    $sellorder = new SellOrder($db);
    $sellorder->id=$id;
    $sellorder->coinsn = $authresponse["sn"];
    $sellorder->qty=$qty;
    $sellorder->price=$price;
    $sellorder->currency = $currency;
    $sellorder->created = "";
    $sellorder->status = 1;
    $sellorder ->paymentmethod = $paymentmethod;

    if($sellorder->update($qty,$price,$currency,$paymentmethod,$id)) {
        echo "success";
        http_response_code(200);
    // show products data in json format
        echo json_encode(array("message" => "Updated Sell Order successfully"));
        
    }
    else {
     
        http_response_code(401);
        echo json_encode(array("message" => "Error updating Sell Order"));
        
    }
}
else {
    http_response_code(401);
 
    echo json_encode(array("message" => "Unauthorised request"));

}

?>