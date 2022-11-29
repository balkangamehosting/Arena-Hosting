<?php
	session_start();
	$valuta = $_SESSION['valuta'];
	if($valuta != "eur"){
	switch($valuta){
			case 'km':
				$val = "BAM";
			break;
			case 'eur':
				$val = "EUR";
			break;
			case 'din':
				$val = "RSD"; 
			break;
			case 'mkd':
				$val = "MKD"; 
			break;
			case 'kn':
				$val = "HRK"; 
			break;
		}
	
  if($valuta == "km"){
	error_reporting(0);
  $slots = $_GET['slots'];
		if($slots == "12"){ $price = "6"; }
		if($slots == "14"){ $price = "7"; } 
		if($slots == "16"){ $price = "8"; } 
		if($slots == "18"){ $price = "9"; } 
		if($slots == "20"){ $price = "10"; }
		if($slots == "22"){ $price = "11"; }
		if($slots == "24"){ $price = "12"; }
		if($slots == "26"){ $price = "13"; } 
		if($slots == "28"){ $price = "14"; }
		if($slots == "30"){ $price = "15"; } 
		if($slots == "32"){ $price = "16"; }
		
		if($slots == "50"){ $price = "7"; }
		if($slots == "100"){ $price = "14"; }
		if($slots == "150"){ $price = "20"; }
		if($slots == "200"){ $price = "24"; }
		echo $price;
  } else {
  $amount = $_GET['amount'];
	$from_Currency = "EUR";
	
	$to_Currency = $val;
  $amount = urlencode($amount);
  $from_Currency = urlencode($from_Currency);
  $to_Currency = urlencode($to_Currency);
  $get = file_get_contents("https://finance.google.com/bctzjpnsun/converter?a=$amount&from=$from_Currency&to=$to_Currency");
  $get = explode("<span class=bld>",$get);
  $get = explode("</span>",$get[1]);  
  $converted_amount = explode(".",preg_replace("/[^0-9\.]/", null, $get[0]));
  $converted_amount = $converted_amount[0];
  echo $converted_amount;
  }
  } else {
  echo $_GET['amount'];
  }
  ?>