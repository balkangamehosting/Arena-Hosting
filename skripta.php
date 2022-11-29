<?php /*
	
	$file = "";
	$handle = fopen("format1.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $e = explode(" * ", $line);
		if($e[0] == 'samp'){$game = "2";} else if($e[0] == 'cs'){$game= '1';}
		$cms_username = $e[1]."".rand(1,9);
		$slotovi = $e[2];
		$box = "1"; // [3]
		$port = $e[4];
		$imeserva = $e[5];
		$ftp_user = $e[6];
		$pw_ftp = $e[7];
		$price = $e[8];
		
		
		
		
		$cms_username = str_replace(" ", "", $cms_username);
		
		$sifra = $cms_username."123";

		$datum_stka = time()+2592000;
		$cpass = md5($sifra);
		$pincode = rand(0,9999);
		mysql_query("INSERT INTO users (username,ime,prezime,password,email,register_time,rank,pin) VALUES ('$cms_username','$cms_username','$cms_username','$cpass','tbedit@edit.com','".date("d.m.Y. - G:i")."','0',".$pincode.")") or die(mysql_error());
		$insertid = mysql_insert_id();
		
		mysql_query("INSERT INTO servers (game,box,slots,status,userid,price,datum_aktivacije,datum_isteka,ime_servera,default_map,port,ftp_username,ftp_password)
		VALUES ('$game','1', '$slotovi', '1', '$insertid', '$price', '".time()."','$datum_stka','$imeserva','de_dust2', '$port','$ftp_user', '$pw_ftp')") or die(mysql_error());
		
		
		echo "
		Username: $cms_username<br />
		Password: $sifra<br />
		PIN: $pincode <br /><br /><br />
		";
		
		
    }
} else {
    // error opening the file.
} 
fclose($handle);
?>