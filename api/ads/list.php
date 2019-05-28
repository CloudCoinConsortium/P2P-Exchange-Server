<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// include database and object files
include_once '../../config/database.php';
include_once '../../objects/ads.php';
include_once '../../middleware/authenticate.php';
include_once '../../test.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$ticket= $_GET['ticket'];
$raida = $_GET['raida'];

$authresponse = authenticate($ticket,$raida);
$opt= isset($_GET['opt'])?$_GET['opt']:"";

$offset= isset($_GET['offset'])?$_GET['offset']:null;
 $pageSize = isset($_GET['pagesize'])?$_GET['pagesize']:null;

    if($offset == null) {
        $offset = 0;
    }
    if($pageSize == null) {
        $pageSize = 20;
    }
if(!$authresponse["result"]) {
    
    // initialize object
$ads = new Ads($db);
$sn = $authresponse["sn"];
$sn="6301000";
// query products
$stmt = $ads->readAdsList($offset, $pageSize, $sn, $opt);
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
            "ad_id" => $ad_id,
            "title"=>$title,
            "description"=>$description,
            "email" => $email,
            "price" => $price,
            "date_posted" => $date_posted,
            "country"=>$country,
            "region_state"=>$region_state,
            "city"=>$city,
            "top_catagory"=>$top_catagory,
            "sub_catagory"=>$sub_catagory,
            "latitude"=>$latitude,
            "longitude"=>$longitude
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
        array("message" => "No ad found.", "authresponse" => $authresponse)
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