<?php

/*
Created by Navraj
https://raida18.cloudcoin.global/exchange/users/create?ticket=12345678901234567890123456789012345678901234&raida=18&id=16777215&email=sean@worthington.net&phone=5305917028
*/


// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);

// include database and object files
include_once '../database.php';
#include_once '../../objects/sellorder.php';
include_once '../user.php';
include_once '../authenticate.php';
include_once '../test.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$ticket= isset($_GET['ticket'])?$_GET['ticket']:"";
$raida = isset($_GET['raida'])?$_GET['raida']:"";
$id= isset($_GET['id'])?$_GET['id']:"";

$authresponse = authenticate($ticket,$raida, $id);


if( $authresponse["result"]) { //WN
    $coinssn = $authresponse["sn"];
    $user = new User($db);
    $user->coinsn = $coinssn;
    $user->email=isset($_GET['email'])?$_GET['email']:"";
    $user->coinsn = $id; // WN
    if($user->validate()){
        $chkExt = $user->user_exist();
        $chkCount = $chkExt->rowCount();
        $isNewUser = true;
        $dbresult = false;
        $isDuplicate = false;
        if($chkCount>0){
            $dbresult =  $user->update();
            $isNewUser = false;
        }else{

        $chkExt = $user->user_duplicate();
        $chkCount = $chkExt->rowCount();
        if($chkCount<1){
           $dbresult = $user->create();
            }else{
               $isDuplicate = true; 
            }
        }

    $messageResponse = "Something went wrong, please try again.";
    if($dbresult==false && $isNewUser==true){
         http_response_code(401);
         if($isDuplicate){
            $messageResponse = "Email Already exist.";
         }else{
             
        $messageResponse = "Error creating new user.";
        }
    }elseif($dbresult==false && $isNewUser==false){
         http_response_code(401);
        $messageResponse = "Error Updating new user.";
    }elseif($dbresult==true && $isNewUser==true){
        http_response_code(200);
        $messageResponse = "Successfully Added record.";
    }elseif($dbresult==true && $isNewUser==false){
        http_response_code(200);
        $messageResponse = "Successfully Updated record.";
    }

    }else{
        http_response_code(401);
        $messageResponse = "Invalid request.";
    }

    echo json_encode($user);
    echo json_encode($messageResponse);

}
else {
    http_response_code(401);
    // show products data in json format
    echo json_encode("Unauthorised");
}

?>