<?php
// [QMCart V1]
//

// [SITE SETTINGS]
//
$shopName = "Online QMCoin Store";
$currency = ' QMC '; //Currency sumbol or code
$fee = 0; //Fees for admin, handling, etc...
$adminEmail = "qmcoin@gmail.com";
$domain = "localhost";
$coldStorageAddress = "Qif72dQRvDWof2Vqxzmqhb8n9ajVjnFKZq"; // Address for coins to be sent after transaction confirmation for security
$mandrilApi = "1ZBmRILLJEoKraY1DtebFQ"; // API key for MAIQMCHIMP from Mandril, free 12,000 mails a month go sign up!

// [DATABASE]
//
$db_username = 'root';
$db_password = 'test';
$db_name = 'QMCart';
$db_host = 'localhost';
$mysqli = new mysqli($db_host, $db_username, $db_password,$db_name);

// [DAEMON SETTINGS]
//
$rpcserver = "localhost";
$rpcport = "55777";
$rpcuser = "qmcrpc";
$rpcpass = "674fmYLqQVyRyBFm1CKmFv681auM9xLDKBBbzworvQxu";

// [DISPLAY]
//
$displayWalletStats = True; // Shows only blockcount, is daemon online, connections. Default is ON
$styleSheet = "style.css";
$coinLogo = "qmc.png";
$displayBTC_USD = False;
$displayQMC_BTC = False;
$displayQMC_USD = False;

// [DO NOT EDIT BELOW HERE UNLESS YOU KNOW WHAT YOU ARE DOING]
//
//
// [DEBUG]
//
$debug = False; //

// [UPGRADE]
//
$versionCheck = True; // Site checks for new version, if found a email is sent to site admin
$versionFile = "https://raw.githubusercontent.com/QMCoin/QMCart/master/version.txt"; // Leave this, this is the file that is checked for new versions, security patches, etc

// [DONATION]
// One can remove this here, simple change to 0.0 or False, but consider this free open source software needs
// more development, if you leave the donation in place more features can be made available to the community.
// its completely transparent, and was not hidden in code obscurely, the option to remove it is right here.
// Please see wiki on github for more information, but consider leaving it. 
$donation = False; // Please leave to true, change below  to a low percent must be over 0.01
$donationAmount = 1; // Donation for development of QMCart, must remain over 0.01, this is a percentage of each sale.
// This is how such software can remain free and plugins, tools, themes and future development be added to it, if you support QMCoin QMC,
// Please consider supporting QMCart.

?>
