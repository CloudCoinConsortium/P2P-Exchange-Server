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
echo json_encode('test');

if($authresponse) {
    //echo json_encode('test');
    
    // show products data in json format
    //echo json_encode("Added");
    $user = new User($db);
    $user->coinsn =2;
    $user->username='navraj1';
    $user->email='navraj1@outlook.com';

    //$result = $user.create();
    //echo json_encode("Added record 0");
    // echo json_encode($user->username);


    if($user->create()) {
        http_response_code(200);
    // show products data in json format
        echo json_encode("Added record ");
    }
    else {
        echo json_encode("Error Creating user.");
  
    }
}
else {
    http_response_code(401);
 
    // show products data in json format
    echo json_encode("Error--");

}

?>