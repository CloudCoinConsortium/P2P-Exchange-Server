<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

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

$ticket= $_GET['ticket'];
$raida = $_GET['raida'];
$id= $_GET['id'];

$authresponse = authenticate($ticket,$raida);

//echo json_encode($ticket);

if($authresponse) {
    //echo json_encode('test');
    
    // show products data in json format
    //echo json_encode("Added");
    $user = new User($db);
    $user->coinsn =2;
    $user->username=$_GET['username'];
    $user->email=$_GET['email'];

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