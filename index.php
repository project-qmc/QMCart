<?php
// QMCart 
// QMCoin shopping cart

// uses rpc to generate address and check confirmations, then after confirmations coins sent to offline wallet address
// stores bulk coins offline in cold storage
// uses live rpc 
// has QMC and BTC ticker, in USD and in BTC prices
// anonymous
// email sent to shop owner on purchase
// shipping details if required sent to shop owner and stored on database
// fully customizable
// configurable confirmation time, and much more
//
//
//DEBUG
if ($debug == True) {
  echo "[DEBUG TURNED ON, SHOWING ERRORS!]";
  ini_set('display_errors',1);
  ini_set('display_startup_errors',1);
  error_reporting(-1);
}else{
}
//END DEBUG 

session_start();

include "polApi.php";
include_once("config.php");
require_once 'jsonRPCClient.php';

$bitcoin = new jsonRPCClient("http://$rpcuser:$rpcpass@$rpcserver:$rpcport/");
//print_r($bitcoin->getinfo()); 
//echo "\n";
$blockcount = $bitcoin->getblockcount();
$daemonConnections = $bitcoin->getconnectioncount();
$daemonBlockCount = $bitcoin->getblockcount();


  
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>QMCart v0.1</title>
<? echo "<link href=\"style/$styleSheet\" rel=\"stylesheet\" type=\"text/css\">"; ?>
</head>

<body>

<div id="products-wrapper">
	<?
		if($blockcount >= 0){
			if($displayWalletStats == True){
				echo "<center><h5>Daemon Online: <font color=\"green\">True</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Connections: <font color=\"green\">$daemonConnections</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Block Count: <font color=\"green\">$daemonBlockCount</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5></center>";
			}else{
				    echo "";
		
				}
		}else{
			echo '<h5>Daemon Online: <font color="red">False</font></h5>';		
			}
			
	?>
	<br>
	<p><h1><center><? echo $shopName; ?><center></h1></p>
	</br>
    <div class="products">
    <?php
    //current URL of the Page. cart_update.php redirects back to this URL
	$current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    
	$results = $mysqli->query("SELECT * FROM products where hidden=0 ORDER BY id ASC");
    if ($results) { 
	
        //fetch results set as object and output HTML
        while($obj = $results->fetch_object())
        {
			echo '<div class="product">'; 
            echo '<form method="post" action="cart_update.php">';
			echo '<div class="product-thumb"><img src="images/'.$obj->product_img_name.'"></div>';
            echo '<div class="product-content"><h3>'.$obj->product_name.'</h3>';
            echo '<div class="product-desc">'.$obj->product_desc.'</div>';
            echo '<div class="product-info">';
			echo 'Price '.$currency.$obj->price.' | ';
            echo 'Qty <input type="text" name="product_qty" value="1" size="3" />';
			//echo '<input type="image" src="images/cart.png" name="button" width="50" height="50">';
			echo '<button class="add_to_cart">Add To Cart</button>';
			echo '</div></div>';
            echo '<input type="hidden" name="product_code" value="'.$obj->product_code.'" />';
            echo '<input type="hidden" name="type" value="add" />';
			echo '<input type="hidden" name="return_url" value="'.$current_url.'" />';
            echo '</form>';
            echo '</div>';
			
        }
    
    }
    ?>

   </div>

<div class="shopping-cart">
<? echo "<br><img height=\"40\" witdh=\"40\" style=\"margin-top:0px; margin-left:0px;\" src=\"images/cart.png\"><h2>Your QMCart</h2>   "; ?>

<?php
if(isset($_SESSION["products"]))
{
    $total = 0;
    echo '<ol>';
    foreach ($_SESSION["products"] as $cart_itm)
    {
        echo '<li class="cart-itm">';
        echo '<span class="remove-itm"><a href="cart_update.php?removep='.$cart_itm["code"].'&return_url='.$current_url.'">&times;</a></span>';
        echo '<h3>'.$cart_itm["name"].'</h3>';
        echo '<div class="p-code">P code : '.$cart_itm["code"].'</div>';
        echo '<div class="p-qty">Qty : '.$cart_itm["qty"].'</div>';
        echo '<div class="p-price">Price :'.$currency.$cart_itm["price"].'</div>';
        echo '</li>';
        $subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
        $total = ($total + $subtotal);
    }
    echo '</ol>';
    echo '<span class="check-out-txt"><strong>Total : '.$currency.$total.'</strong> <a href="view_cart.php">Check-out!</a></span>';
	echo '<span class="empty-cart"><a href="cart_update.php?emptycart=1&return_url='.$current_url.'">Empty Cart</a></span>';
}else{
    echo 'Your Cart is empty';
}
?>

</div>


   <? echo "<img style=\"margin-top:22px; margin-left:40px;\" src=\"images/$coinLogo\"><br>"; ?>
   
  
</div>


</body>



</html>
