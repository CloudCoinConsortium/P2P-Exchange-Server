<?php
function getRaidaUrl($raidanum) {
 //return "https://RAIDA".$raidanum.".CloudCoin.Global/service/";
    return "https://RAIDA".$raidanum.".CloudCoin.Global/service/";
}

function executeCurl($url) {
  
  $hints = file_get_contents($url);
    return $hints;
} 

function authenticate($ticket, $raidanum, $id_sn) {
    //$obj = getTestTicket();
    $ticketurl = getRaidaUrl($raidanum) . "hints?rn=" . $ticket . "";
	//echo "Request: $ticketurl<br>" ;
    $response = executeCurl($ticketurl);
    $reply = explode(":", $response);
	//echo "$response Reply is ".$reply[0] . " id sn =$id_sn . They should be the same.";
    if($reply[0] == $id_sn && intval($reply[0]) > 0 ) { // The response should be the same as the user's SN and not a negative number
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