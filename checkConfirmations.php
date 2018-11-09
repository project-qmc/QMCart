<?php
//echo "[DEBUG TURNED ON, SHOWING ERRORS!]";
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

//echo rand(1,10); echo rand(1,10); echo rand(1,10); echo rand(1,10); echo rand(1,10);
echo "<br>";	
include("config.php");
require_once("jsonRPCClient.php");
require_once("./mandrill-api-php/src/Mandrill.php"); //Not required with Composer'

$mandrill = new Mandrill($mandrilApi);

$address = $_GET["address"];
$shippingAddress = $_GET["shippingaddress"];
$total = $_GET["total"];
$productName = $_GET["product"];
$donate = $_GET["donate"];
$done = $_GET["done"];
$name = $_GET["name"];
$email = $_GET["email"];

$bitcoin = new jsonRPCClient("http://$rpcuser:$rpcpass@$rpcserver:$rpcport/"); 
$balance = $bitcoin->getreceivedbyaddress($address, 1); // 1 confirmations

if($balance >= $total){
	$confirmed = True;
}else{
	$confirmed = False;
}

$int = rand(0,3);
$loading = array("..|..",".... / ....",".... | ....",".. \\ ..");
$rand_symbol = $loading[$int];

echo "<b>$rand_symbol</b><br>";

if($confirmed == True){
	if($done == "False"){
		
		
		// Store shipping details if required in database
		$link = mysqli_connect($db_host, $db_username, $db_password);// or die('not connected'); 
		mysqli_select_db($link, $db_name); 
		$query = "INSERT INTO `orders` (`name`, `coin_address`, `email`) VALUES (\"".mysqli_real_escape_string($link, $name)."\", \"".mysqli_real_escape_string($link, $address)."\", \"".mysqli_real_escape_string($link, $email)."\")"; 
		mysqli_query($link, $query); 
		mysqli_close($link); 
		

		$message2 = array(				
		    'text' => "Purchase has been made for $productName, payment made to address:$address, amount paid $total buyers email, $email",
			'subject' => "Purchase Made $productName",
			'from_email' => 'QMCart@qmc.network',
			'from_name' => 'QMCart Installation',
			'to' => array(
				array(
					'email' => "$adminEmail",
					'name' => 'QMCart Admin',
					'type' => 'to'
				)
			)				
		);
		$async = false;
		$ip_pool = 'Main Pool';
		$sendMailResult2 = $mandrill->messages->send($message2, $async, $ip_pool);
		#print_r($sendMailResult2);		
		
		
		$message3 = array(				
		    'text' => "Purchase has been made for $productName, payment made to address:$address, amount paid $total",
			'subject' => "Receipt for $productName",
			'from_email' => 'QMCart@qmc.network',
			'from_name' => 'QMCart Purchase',
			'to' => array(
				array(
					'email' => "$email",
					'name' => 'Customer',
					'type' => 'to'
				)
			)				
		);
		$async = false;
		$ip_pool = 'Main Pool';
		$sendMailResult3 = $mandrill->messages->send($message3, $async, $ip_pool);
		#print_r($sendMailResult3);	
		$done = "True";
	}else{
	}	
	echo "<b>Confirmed: </b><i>True</i>";
	echo "<br>";
	echo "<b>Balance:</b><i> $balance</i>";
	echo "<br>";
	echo "<B>You may close the page !</B>";
	
}else{
	echo "<b>Confirmed:</b><i> False</i>";
	echo "<br>";
	echo "<b>Balance:</b><i> $balance</i>";
	echo "<br>";
	echo "Check again, click button, in 5min.";
}
?>
