<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// database connection will be here

// include database and object files
include_once '../../config/database.php';
include_once '../../objects/transaction.php';
include_once '../../middleware/authenticate.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$ticket= $_GET['ticket'];
$raida = $_GET['raida'];

$id = $_GET['id'];
$rating = $_GET['rating'];
$comment = $_GET['comment'];

$authresponse = authenticate($ticket,$raida);
//echo json_encode($ticket);

if($authresponse["result"]) {
    $transaction = new Transaction($db);
    $transaction->id= $id;
    $transaction->coinsn = $authresponse["sn"];
    $result = $transaction->rate($rating,$comment,$id);
    if($result) {
        http_response_code(200);
        // show products data in json format
        echo json_encode(array("message" => "Transaction Rated Successfully."));

    }
    else {
        http_response_code(401);
    // show products data in json format
        echo json_encode(array("message" => "Can not Rate this transaction."));

    }
}
else {
    http_response_code(404);
    // show products data in json format
        echo json_encode(array("message" => "Unauthorised Transaction"));
}
?>