<?php
session_start();
include('connect_db.php');
if($_SESSION['userid'] == ""){
   die("<script> alert('Ulogujte se prvo.'); document.location.href='/'; </script>");
}


if($_GET['task'] == 'add'){
	$iznos 		= mysql_real_escape_string(strip_tags($_POST['iznos']));
	$valuta 	= mysql_real_escape_string(strip_tags($_POST['valuta']));
	$uplatioc 	= mysql_real_escape_string(strip_tags($_POST['uplatioc']));
	$datum		= mysql_real_escape_string(strip_tags($_POST['datum']));
	$racun 		= mysql_real_escape_string(strip_tags($_POST['racun']));
	$drzava 	= mysql_real_escape_string(strip_tags($_POST['drzava']));
	$uplatnica_tmp_name = $_FILES['uplatnica']['tmp_name'];
	$uplatnica_name 	= $_FILES['uplatnica']['name'];
	
	$iznos = konvertuj($iznos, $valuta);
	
	$filen = explode(".", $uplatnica_name);
	$file_extension = end($filen);
	
	$up_dir = "uplatnice/";
	$mix_random = rand(111111,99999999);
	$new_name = $up_dir.time().$mix_random.".".$file_extension;
	
	if($file_extension == "jpeg" or $file_extension == "jpg" or $file_extension == "png" or $file_extension == "bmp" ){
		if(move_uploaded_file($uplatnica_tmp_name, $new_name)){
			mysql_query("INSERT INTO uplate (iznos,datum,vrsta_uplate,userid,valuta,bank_uplatioc,bank_datum,bank_racun,bank_drzava,bank_uplatnica) VALUES ('$iznos', '".time()."', 'bank', '".$_SESSION['userid']."', 'EUR', '$uplatioc', '$datum', '$racun', '$drzava', '$new_name')") or die(mysql_error());
			$_SESSION['ok'] = "Uspjesno dodana uplata!";
			header("location:/gp/billing");
		} else {
			$_SESSION['error'] = "Dogodila se greska prilikom uploada!";
			header("location:/gp/billing");
		}
	}
}
?>