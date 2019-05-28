<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 ini_set('display_errors', 0);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// include database and object files
include_once '../../config/database.php';
#include_once '../../objects/sellorder.php';
include_once '../../objects/user.php';
include_once '../../middleware/authenticate.php';
include_once '../../test.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$ticket= isset($_GET['ticket'])?$_GET['ticket']:"";
$raida = isset($_GET['raida'])?$_GET['raida']:"";

$authresponse = authenticate($ticket,$raida);
if(!$authresponse["result"]) { //WN
    $coinssn = $authresponse["sn"];
    $user = new User($db);
    $user->coinsn = $coinssn;
    $user->coinsn = 222;

$fileupload = $user->file_upload();
if($fileupload['status'] !=0){
	$filename = $fileupload['filename'];
    $user->profile_img=$filename;
    $chkExt = $user->user_exist();
    $chkCount = $chkExt->rowCount();
    $isNewUser = true;
    $dbresult = false;
    if($chkCount>0){
       $dbresult =  $user->upload();
        
    }else{
      $messageResponse = "User not find, please try again."; 
    }
}else{
    http_response_code(401);
    $messageResponse = $fileupload['message'];
}
$messageResponse = (!empty($messageResponse)?$messageResponse:"Faield to upload.");
//$messageResponse = "Something went wrong, please try again.";
	if($dbresult==true){
		http_response_code(200);
	        $messageResponse = "File uploaded.";
	}else{
		 	http_response_code(401);
	        //$messageResponse = "Failed to upload.";
	}
    
   
    echo json_encode($messageResponse);

}
else {
    http_response_code(401);
    // show products data in json format
    echo json_encode("Error--");
}



?>