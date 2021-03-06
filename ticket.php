<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once('./middleware/authenticate.php');

function getTicketUrl($nn,$sn,$an,$pan,$denomination) {
    return getRaidaUrl(0) . "get_ticket?nn=" .$nn. "&sn=".$sn. "&an=" .$an."&pan=".$pan."&denomination=".$denomination;
}
   
$nn= $_GET['nn'];
$sn = $_GET['sn'];
$an = $_GET['an'];
$pan = $_GET['pan'];
$denomination = $_GET['denomination'];

$ticketurl = getTicketUrl($nn,$sn,$an,$pan,$denomination);

$ch = curl_init();
 
//Set the URL that you want to GET by using the CURLOPT_URL option.
curl_setopt($ch, CURLOPT_URL, $ticketurl);
 
//Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
//Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
 
//Execute the request.
$data = curl_exec($ch);
 
//Close the cURL handle.
curl_close($ch);
 

http_response_code(200);
 
//     // tell the user no products found
 echo json_encode(
         array("nn" => $nn, "sn" => $sn, "an" => $an , "pan" => $pan , "ticket_response" => preg_replace('/\\\\/', '', $data)) 
     );

   //  echo json_encode(preg_replace('/\\\\/', '', $data));

?>