<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// include database and object files
include_once '../database.php';
include_once 'sellorder.php';
include_once  '../../middleware/authenticate.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$ticket = 0; //$_GET['ticket'];
$raida = $_GET['raida'];

$idSN = isset($_GET['sn']) ? $_GET['sn'] : 0;

//$authresponse = authenticate($ticket,$raida,$idSN);
$opt= $_GET['opt'];

$offset= $_GET['offset'];
    $pageSize = $_GET['pagesize'];

    if($offset == null) {
        $offset = 0;
    }
    if($pageSize == null) {
        $pageSize = 20;
    }

    // initialize object
$sellorder = new SellOrder($db);
$sn = $idSN;

// read products will be here

// query products
$stmt = $sellorder->readSellOrders($offset, $pageSize, $sn, $opt);
$num = $stmt->rowCount();
//$sql = readsql();
// check if more than 0 record found
if($num>0){
 
    // products array
    $products_arr=array();
   // $products_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
	
	
	$json ="{ ";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row); 
 
      $product_item=array(
            "id" => $id,
            "username" => $coinsn,
			"sellerid" => $coinsn,
            "quantity" => $qty,
            "price" => $price,
            "currency" => $currency,
            "dateposted" => $dateposted,
            "paymentmethod" => $paymentmethod,
			"userurl" => $userurl,
        );
		  /*	
		$json .='"id":'.$id.',';
		$json .='"username":"'.$coinsn.'",';
		$json .='"quantity":'.$qty.',';
		$json .='"price":'.$coinsn.',';
		$json .='"currency":"'.$currency.',"';
		$json .='"dateposted":"'.$dateposted.'",';
		$json .='"paymentmethod":"'.$paymentmethod.'"';
*/
        array_push($products_arr, $product_item);
    }
 
    // set response code - 200 OK
    //http_response_code(200);
 
    // show products data in json format
	//$json .="}";
	//die( $json );
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




?>
 

