<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);

// include database and object files
include_once '../../config/database.php';
include_once '../../objects/user.php';
include_once '../../middleware/authenticate.php';
include_once '../../test.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$ticket= isset($_GET['ticket'])?$_GET['ticket']:"";
$raida = isset($_GET['raida'])?$_GET['raida']:"";
$user_sn= isset($_GET['user_sn'])?$_GET['user_sn']:"";
$action= isset($_GET['action'])?$_GET['action']:"";

$authresponse = authenticate($ticket,$raida);

if($authresponse) {
    $coinsn = $authresponse["sn"];
    $user = new User($db);
    $coinsn = (!empty($user_sn))?$user_sn:$coinsn;
    $user->coinsn = $coinsn;
    $userst = $user->read_sn();
    $result = $userst->fetchAll(PDO::FETCH_CLASS);
    $totalCnt = $userst->rowCount();

    if($totalCnt>0){
    	 http_response_code(200);
         if($action=="download_profile"){
          //print_r($result[0]);
          $siteURL = "http://" . $_SERVER['SERVER_NAME']."/store/uploads/";
          $siteURL = $siteURL.$result[0]->profile_img;
          //echo $siteURL;
          download_image($result[0]->profile_img);
          $responseData['user'] = $result[0];
          echo json_encode($responseData);
         }else{
          if(!empty($result[0]->profile_img)){
          $profileimage = $siteURL = "http://" . $_SERVER['SERVER_NAME']."/store/uploads/".$result[0]->profile_img;
          $result[0]->profile_img = $profileimage;
        }
    	   $responseData['user'] = $result[0];
         echo json_encode($responseData);
        }
    	
    }else{
    	 http_response_code(200);
    	 echo json_encode("Not a valid request.");

    }
    
}else{
	 http_response_code(401);
    // show products data in json format
    echo json_encode("Error--");
}

function download_image($file){
    var_dump($file);
    $file = "../../uploads/".$file;
    if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}
}
?>