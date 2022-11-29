<?php
session_start();
 include("connect_db.php");
$order_id	= mysql_real_escape_string($_GET['id']);
$order_type	= $_GET['type'];
$country	= $_GET['country'];
error_reporting(1);



header("Content-type: image/png");
$black		= imagecolorallocate($image, 0, 0, 0);
$font		= "files/misc/arial.ttf";
$day		= wordwrap(date("d"), 1, " ", true);
$month		= wordwrap(date("m"), 1, " ", true);
$year		= wordwrap(date("y"), 1, " ", true);
$year2		= wordwrap(date("Y"), 1, " ", true);

	if($order_type=='game'){
		$order_query	= mysql_query("SELECT * FROM servers WHERE id='$order_id'") ;
			if(mysql_num_rows($order_query)==0){die();}
		// order info
		$order_row		= mysql_fetch_assoc($order_query);

			$order_price	= $order_row['price']; // in euro
			$order_uid		= $order_row['userid'];
			
			$test = mysql_query("SELECT ime, prezime FROM users WHERE userid='$_SESSION[userid]'");
			$mysqlfetf = mysql_fetch_array($test);
			
			$nameba   = $mysqlfetf['ime'];
			$snameba   = $mysqlfetf['prezime'];

	}
	$user_full_name = $nameba .' '.  $snameba;
	
	
	
		
		
