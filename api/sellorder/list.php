<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../../config/database.php';
include_once '../../objects/sellorder.php';
include_once '../../middleware/authenticate.php';
include_once '../../test.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$ticket = getTestTicket();

$authresponse = authenticate(6300997, $ticket["ticket"],0);
$opt= $_GET['opt'];

$offset= $_GET['offset'];
    $pageSize = $_GET['pagesize'];

    if($offset == null) {
        $offset = 0;
    }
    if($pageSize == null) {
        $pageSize = 20;
    }
if($authresponse) {
    
    // initialize object
$sellorder = new SellOrder($db);
 
// read products will be here

// query products
$stmt = $sellorder->readSellOrders($offset, $pageSize);
$num = $stmt->rowCount();
//$sql = readsql();
// check if more than 0 record found
if($num>0){
 
    // products array
    $products_arr=array();
    $products_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $product_item=array(
            "RecordId" => $id,
            "uName" => $name,
            "Quantity" => $qty,
            "Rate" => $price,
            "Currency" => $currency,
            "Dated" => $dateposted,
            "PayBy" => $paymentmethod
        );
 

        array_push($products_arr["records"], $product_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($products_arr);
}
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No Sell Orders found.", "authresponse" => $authresponse)
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
 

