<?php
function getRaidaUrl($raidanum) {
 //return "https://RAIDA".$raidanum.".CloudCoin.Global/service/";
    return "https://".$raidanum.".CloudCoin.Global/service/";
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

function authenticate($ticket, $raidanum) {
    //$obj = getTestTicket();
    $ticketurl = getRaidaUrl($raidanum) . "hints?rn=" . $ticket . "";
    $response = executeCurl($ticketurl);
    $reply = explode(":", $response);
    if($reply[0]>0) {
       return array(
            "result" => true,
            "sn" => $reply[0]
       );
    }
    else {
        return array(
            "result" => false,
            "sn" => $reply[0]
       );

    }
    
}

?>