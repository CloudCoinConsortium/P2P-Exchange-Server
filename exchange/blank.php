<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
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

if($authresponse == true) {
    
    http_response_code(200);
    // show products data in json format
    echo json_encode("Added");
    $user = new User($db);


}
else {
    http_response_code(200);
 
    // show products data in json format
    echo json_encode("Error--");

}

?>