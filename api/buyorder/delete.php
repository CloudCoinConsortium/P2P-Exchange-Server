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
include_once '../../test.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$ticket = getTestTicket();

$authresponse = authenticate(6300997, $ticket["ticket"],0);
//echo json_encode($ticket);
echo json_encode($authresponse);

if($authresponse) {
    //echo json_encode('test');
    
    $sellorder = new SellOrder($db);
    $sellorder->id=3;
    $sellorder->coinsn =3;
    $sellorder->qty='50000';
    $sellorder->price='0.02';
    $sellorder->currency = "USDD";
    $sellorder->created = "";
    $sellorder->status = 1;
    $sellorder ->paymentmethod = "Paypal";

    if($sellorder->delete()) {
        http_response_code(200);
    // show products data in json format
        echo json_encode("Deleted the Sell Order");
    }
    else {
        http_response_code(401);
        echo json_encode("Error Deleting Sell Order.");
    }
}
else {
    http_response_code(401);
 
    echo json_encode("Error--");

}

?>