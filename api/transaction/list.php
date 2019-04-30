<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// database connection will be here
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// include database and object files
include_once '../../config/database.php';
include_once '../../objects/transaction.php';
include_once '../../middleware/authenticate.php';

 

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// $ticket = getTestTicket();

$ticket= $_GET['ticket'];
$raida = $_GET['raida'];

///echo $ticket;

$authresponse = authenticate($ticket,$raida);

$opt= $_GET['opt'];

$offset= $_GET['offset'];
    $pageSize = $_GET['pagesize'];

    if($offset == null) {
        $offset = 0;
    }
    if($pageSize == null) {
        $pageSize = 20;
    }
if($authresponse["result"]) {
    
    // initialize object
$transaction = new Transaction($db);
$sn = $authresponse["sn"];

// query buy orders
$stmt = $transaction->getTransactions($offset, $pageSize,$sn,$opt);
$num = $stmt->rowCount();
// check if more than 0 record found
if($num>0){
 
    // products array
    $transaction_arr=array();
    $transaction_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $transaction_item=array(
            "RecordId" => $id,
            "SellerName" => $seller,
            "Quantity" => $qty,
            "Rate" => $price,
            "Currency" => $currency,
            "Dated" => $transactiondate,
            "PayBy" => $paymentmethod,
            "BuyerName" => $buyer,
            "BuyerComment" =>$buyercomment,
            "SellerComment" =>$sellercomment,
            "BuyerRating" =>$buyerrating,
            "SellerRating" =>$sellerrating
        );
 

        array_push($transaction_arr["records"], $transaction_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($transaction_arr);
}
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No Transactions found.")
    );
}
}
else {
    http_response_code(401);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "Unauthorised.")
    );

}




?>
 

