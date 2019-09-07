<?php

    // specify your own database credentials
   /* private $host = "204.11.58.166";
    private $db_name = "navraggl_exchangecc";
    private $username = "exchangeprg";
    private $password = "54\$nM3mw";
    */

   $host = "localhost";
   $db_name = "exchange";
   $username = "root";
   $password = "";

		//Connect to DBData
	$conn = mysqli_connect( $host, $username, $password, $db_name);
	if (!$conn) {
			  echo "Connect error: ".mysqli_connect_error(); //Delete sql error later
		  die();
	}//end if


?>