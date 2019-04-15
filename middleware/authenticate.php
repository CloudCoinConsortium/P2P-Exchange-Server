<?php

function getRaidaUrl($raidanum) {
 return "https://RAIDA".$raidanum.".CloudCoin.Global/service/";
}

function authenticate($sn, $ticket, $raidanum) {
    $ticketurl = getRaidaUrl($raidanum) . "hints?rn=" . $ticket . "&an=";
    
}

?>