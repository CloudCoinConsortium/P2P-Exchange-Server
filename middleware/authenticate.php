<?php

include_once('../test.php');

function getRaidaUrl($raidanum) {
 return "https://RAIDA".$raidanum.".CloudCoin.Global/service/";
}

function executeCurl($url) {
    $ch = curl_init();
     
    //Set the URL that you want to GET by using the CURLOPT_URL option.
    curl_setopt($ch, CURLOPT_URL, $url);
     
    //Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     
    //Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
     
    //Execute the request.
    $data = curl_exec($ch);
     
    //Close the cURL handle.
    curl_close($ch);
    return $data;
}

function authenticate($sn, $ticket, $raidanum) {
    $obj = getTestTicket();
    
    $ticketurl = getRaidaUrl($raidanum) . "hints?rn=" . $obj["ticket"] . "";
    $response = executeCurl($ticketurl);
    $reply = explode(":", $response);
    //if(reply[0])
    if($reply[0]>0) 
        return true;
    else
        return false;
    
}

?>