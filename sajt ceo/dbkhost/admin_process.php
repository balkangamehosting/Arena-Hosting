<?php
session_start();
include_once ("connect_db.php");
$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$_SESSION[userid]'"));

date_default_timezone_set('Europe/Sarajevo');
$time = date("d.m.Y - h:m:i");

if (isset($_GET['task']) && $_GET['task'] == "prihvati_comment") {
   $id = $_GET['id'];
   
   if($info['rank'] == "1"){
   mysql_query("UPDATE site_comments SET status='1' WHERE id='$id'");
   $_SESSION['ok'] = "Sucess approved message.";
   header("location:/admin");
   } else {
    $_SESSION['error'] = "You dont have acess";
	header("location:/index.php");
	die();
   }
} else if (isset($_GET['task']) && $_GET['task'] == "odbij_komentar") {
   $id = $_GET['id'];
   
   if($info['rank'] == "1"){
   mysql_query("UPDATE site_comments SET status='2' WHERE id='$id'");
   $_SESSION['ok'] = "Sucess disapproved message.";
   header("location:/admin");
   } else {
    $_SESSION['error'] = "You dont have acess";
	header("location:/index.php");
	die();
   }
} else if (isset($_GET['task']) && $_GET['task'] == "obrisi_komentar") {
   $id = $_GET['id'];
   
   if($info['rank'] == "1"){
   mysql_query("DELETE FROM site_comments WHERE id='$id'");
   $_SESSION['ok'] = "Sucess deleted message.";
   header("location:/admin");
   } else {
    $_SESSION['error'] = "You dont have acess";
	header("location:/index.php");
	die();
   }
} else if (isset($_POST['task']) && $_POST['task'] == "prihvati_server") {
   $id = mysql_real_escape_string($_POST['id']);
   
   if($info['rank'] == "1"){
   $d_i = time()+2592000;
   
   $game = mysql_real_escape_string(strip_tags($_POST['game']));
   $ip	 = mysql_real_escape_string(strip_tags($_POST['ip']));
   $port = mysql_real_escape_string(strip_tags($_POST['port']));
   $mapa = mysql_real_escape_string(strip_tags($_POST['mapa']));
   
   $time = time();
   $ftp_username = substr(md5(rand(0,$time)), 0, 10);
   $ftp_password = substr(md5(rand(666,5215251)), 0, 12);
   
   $box_info_q = mysql_fetch_array(mysql_query("SELECT * FROM masine WHERE id='$ip'"));
   
   $box_ip 			= $box_info_q['ip'];
   $box_port		= $box_info_q['ssh_port'];
   $box_username	= $box_info_q['username'];
   $box_password	= $box_info_q['password'];
   
   $game_info_q 	= mysql_fetch_array(mysql_query("SELECT lokacija,protocol FROM igre WHERE id='$game'"));
   $servers_info_q 	= mysql_fetch_array(mysql_query("SELECT slots FROM servers WHERE id='$id'"));
   

   $ssh_dodavanje = ssh_dodaj_server($box_ip, $box_port, $box_username, $box_password, $ftp_username, $ftp_password, $game_info_q['lokacija']);
   
  
   
   
   if($ssh_dodavanje == 'DA'){
		$subject = "Uniq Hosting - Server kreiran";
		$message = "Dobrodosli $ime $prezime, 
		Uspjesno ste se registrovali na Uniq Hosting web sajt. 
		-----------------
		Vas username je: $username
		Vas E-mail je: $email
		Vas PIN Code je: $pincode
		Login stranica : www.uniq-hosting.info
		-----------------
		Uniq Hosting Admin team";
		$from = "From: info@uniq-hosting.info";
		
		mail($email, $subject, $message, $from);
	   mysql_query("UPDATE servers SET status='1', datum_aktivacije='".time()."', datum_isteka='".$d_i."', box='$ip', default_map='$mapa', gamemod='public', port='$port', ftp_username='$ftp_username', ftp_password='$ftp_password' WHERE id='$id'") or die(mysql_error());
	   
	   if($game_info_q['protocol'] == "samp"){
		$srediga = sredi_samp($box_ip, $box_username, $box_password, $ftp_username, $port, $servers_info_q['slots']);
		if($srediga == 'DA'){
			$ok = 1;
		} else {
			$ok = 0;
		}
		} else {}
	   $_SESSION['ok'] = "Uspjesno kreiran server.";
   } else {
	$_SESSION['ok'] = $ssh_dodavanje;
   }
   
   
   
   
   
   
   $selce = mysql_fetch_array(mysql_query("SELECT userid FROM servers WHERE id='$id'"));
   mysql_query("INSERT INTO notifications (userid,message,link) VALUES ('$selce[userid]','Vas server je prihvacen!','/server_orders')");
   mysql_query("INSERT INTO logovi (datum,text,user,ip) VALUES ('".time()."','prihvatio server #$id','$_SESSION[username]','".getenv('REMOTE_ADDR')."')");
   header("location:/admin");
   } else {
    $_SESSION['error'] = "You dont have acess";

	header("location:/index.php");
	die();
   }
} else if (isset($_GET['task']) && $_GET['task'] == "odbij_server") {
   $id = mysql_real_escape_string($_GET['id']);
   
   if($info['rank'] == "1"){
   mysql_query("UPDATE servers SET status='2' WHERE id='$id'");
   $_SESSION['ok'] = "Sucess disapproved server.";
   
   $scan_if = mysql_query("SELECT box,ftp_username FROM servers WHERE id='$id' ");
   $fetch = mysql_fetch_array($scan_if);
   $box_name = mysql_fetch_array(mysql_query("SELECT name,location,ip,username,password FROM masine WHERE id='$fetch[box]'"));
   
   stop_server($box_name['ip'], $box_name['username'], $box_name['password'], $fetch['ftp_username']);
   
   
   $selce = mysql_fetch_array(mysql_query("SELECT userid FROM servers WHERE id='$id'"));
   mysql_query("INSERT INTO notifications (userid,message,link) VALUES ('$selce[userid]','Vas server je suspendovan!','/server_orders')");
   mysql_query("INSERT INTO logovi (datum,text,user,ip) VALUES ('".time()."','suspendovao server #$id','$_SESSION[username]','".getenv('REMOTE_ADDR')."')");
   header("location:/admin");
   } else {
    $_SESSION['error'] = "You dont have acess";
	header("location:/index.php");
	die();
   }
} else if (isset($_GET['task']) && $_GET['task'] == "obrisi_server") {
   $id = $_GET['id'];
   
   if($info['rank'] == "1"){
   mysql_query("DELETE FROM servers WHERE id='$id'");
   $_SESSION['ok'] = "Sucess deleted server.";
   mysql_query("INSERT INTO logovi (datum,text,user,ip) VALUES ('".time()."','obrisao server #$id','$_SESSION[username]','".getenv('REMOTE_ADDR')."')");
   header("location:/admin");
   } else {
    $_SESSION['error'] = "You dont have acess";
	header("location:/index.php");
	die();
   }
} else if (isset($_GET['task']) && $_GET['task'] == "produzi_server") {
   $id = $_GET['id'];
   $prolong = time()+2592000;
   if($info['rank'] == "1"){
   mysql_query("UPDATE servers SET datum_isteka=datum_isteka+2592000, status='1' WHERE id='$id'");
   $_SESSION['ok'] = "Uspjesno produzeno!.";
   mysql_query("INSERT INTO logovi (datum,text,user,ip) VALUES ('".time()."','produzio server #$id','$_SESSION[username]','".getenv('REMOTE_ADDR')."')");
   header("location:/admin/server_review/$id");
   } else {
    $_SESSION['error'] = "You dont have acess";
	header("location:/index.php");
	die();
   }
} else if (isset($_GET['task']) && $_GET['task'] == "delete_points") {
   $userid = addslashes($_GET['userid']);
   
   $info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$userid'"));
   
   if($info['userid'] == ""){
    $_SESSION['error'] = "Korisnik ne postoji";
	header("location:/admin");
	die(); 
   } else {
    mysql_query("DELETE FROM points WHERE userid='$userid'");
	mysql_query("INSERT INTO logovi (datum,text,user,ip) VALUES ('".time()."','obrisao referale clanu #$userid','$_SESSION[username]','".getenv('REMOTE_ADDR')."')");
	header("location:/admin");
	$_SESSION['ok'] = "Uspesno";
   }
} else if (isset($_GET['task']) && $_GET['task'] == "delete_referal") {
    mysql_query("TRUNCATE TABLE points");
	mysql_query("INSERT INTO logovi (datum,text,user,ip) VALUES ('".time()."','OBRISAO SVE REFERALE','$_SESSION[username]','".getenv('REMOTE_ADDR')."')");
	header("location:/admin");
	$_SESSION['ok'] = "Uspesno";
} else if (isset($_GET['task']) && $_GET['task'] == "delete_server") {
    $id = addslashes($_GET['id']);
	
	$infotest = mysql_fetch_array(mysql_query("SELECT * FROM serverinfo WHERE id='$id'"));

	if($_SESSION['userid'] == ""){
	 header("location:/index.php");
	 die();
	}
	
	if($infotest['id'] == ""){
	 $_SESSION['error'] = "Server koji trazite da obrisete ne postoji";
	 header("location:/admin/servers");
	 die();
	} else {}
	
	if($info['rank'] == "1"){
    mysql_query("DELETE FROM serverinfo WHERE id='$id'");
	mysql_query("DELETE FROM players WHERE sid='$id'");
	$_SESSION['ok'] = "Uspesno obrisan server";
	header("location:/admin/servers");
	} else {
	$_SESSION['error'] = "Nemate pristup";
	header("location:/index.php");
	die();
	}
} else if (isset($_GET['task']) && $_GET['task'] == "reset_server") {
    $id = addslashes($_GET['id']);
	
    $infotest = mysql_fetch_array(mysql_query("SELECT * FROM serverinfo WHERE id='$id'"));

	if($_SESSION['userid'] == ""){
	 header("location:/index.php");
	 die();
	}	
	
	if($infotest['id'] == ""){
	 $_SESSION['error'] = "Server koji trazite da obrisete ne postoji";
	 header("location:/admin/servers");
	 die();
	} else {}

    if($info['rank'] == "1"){
    mysql_query("UPDATE serverinfo SET rank_pts='0.000000' WHERE id='$id'");
	$_SESSION['ok'] = "Uspesno restartovali rank";
	header("location:/admin/servers");
	} else {
	$_SESSION['error'] = "Nemate pristup";
	header("location:/index.php");
	die();
	}	
} else if (isset($_GET['task']) && $_GET['task'] == "edit_server") {
	$game = $_POST['game'];
	$location = $_POST['location'];
	$mod = $_POST['mod'];
	$best_rank = mysql_real_escape_string($_POST['best_rank']);
	$worst_rank = mysql_real_escape_string($_POST['worst_rank']);
	$forum = mysql_real_escape_string($_POST['forum']);
	$added = mysql_real_escape_string($_POST['added']);
	$owner = mysql_real_escape_string($_POST['owner']);
	$id = $_POST['sid'];
	
    $infotest = mysql_fetch_array(mysql_query("SELECT * FROM serverinfo WHERE id='$id'"));

	if($_SESSION['userid'] == ""){
	 header("location:/index.php");
	 die();
	}	
	
	if($infotest['id'] == ""){
	 $_SESSION['error'] = "Server koji trazite da obrisete ne postoji";
	 header("location:/admin/servers");
	 die();
	} else {}
	
    if($info['rank'] == "1" && $_SESSION['username'] == "MorpheuS ^^"){
    mysql_query("UPDATE serverinfo SET game='$game', location='$location', gamemod='$mod', best_rank='$best_rank', worst_rank='$worst_rank', forum='$forum', added='$added', owner='$owner' WHERE id='$id'") or die(mysql_error());
	$_SESSION['ok'] = "Uspesno ste izmenili server";
	header("location:/admin/server_edit/$id");
	} else {
	$_SESSION['error'] = "Nemate pristup";
	header("location:/index.php");
	die();
	}		
}  else if (isset($_GET['task']) && $_GET['task'] == "delete_comm") {
    $id = addslashes($_GET['id']);
	
	$infotest = mysql_fetch_array(mysql_query("SELECT * FROM community WHERE id='$id'"));

	if($_SESSION['userid'] == ""){
	 header("location:/index.php");
	 die();
	}
	
	if($infotest['id'] == ""){
	 $_SESSION['error'] = "Zajednica koju trazite da obrisete ne postoji";
	 header("location:/admin/communities");
	 die();
	} else {}
	
	if($info['rank'] == "1"){
	mysql_query("DELETE FROM community WHERE id='$id'");
	$_SESSION['ok'] = "Uspesno obrisana zajednica";
	header("location:/admin/communities");
	} else {
	$_SESSION['error'] = "Nemate pristup";
	header("location:/index.php");
	die();
	}
} else if (isset($_GET['task']) && $_GET['task'] == "reset_comm") {
    $id = addslashes($_GET['id']);
	
    $infotest = mysql_fetch_array(mysql_query("SELECT * FROM community WHERE id='$id'"));

	if($_SESSION['userid'] == ""){
	 header("location:/index.php");
	 die();
	}	
	
	if($infotest['id'] == ""){
	 $_SESSION['error'] = "Zajednicu koju trazite da obrisete ne postoji";
	 header("location:/admin/communities");
	 die();
	} else {}

    if($info['rank'] == "1"){
    mysql_query("UPDATE community SET rank_pts='0.00000' WHERE id='$id'");
	$_SESSION['ok'] = "Uspesno restartovali rank";
	header("location:/admin/communities");
	} else {
	$_SESSION['error'] = "Nemate pristup";
	header("location:/index.php");
	die();
	}	
}
?> 

