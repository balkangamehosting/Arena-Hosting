<?php
error_reporting(0);
// Time ago function

$obavjestenje = "Pusten u rad novi Gpanel :)";
$refs_needed = 100;
// gametracker config
$gt_allowed_countries	= array(
						'Serbia'			=> 'RS',
						'Bosnia and Herzegovina' => 'BA',
						'Croatia'			=> 'HR',
						'Macedonia'			=> 'MK',
						'Montenegro'        => 'ME',
						);

$gt_allowed_games		= array(
						'Counter-Strike'			=> 'cs',
						);
$gt_allowed_mods		= array(
						'Public'				=> 'PUB',
						'Deathmatch'			=> 'DM',
						'Deathrun'				=> 'DR',
						'Gungame'				=> 'GG',
						'KreedZ'				=> 'KZ',
						'HideNSeek'				=> 'HNS',
						'Soccer Jam'			=> 'SJ',
						'Knife Arena'			=> 'KA',
						'Zombie'                => 'ZM',
						'Super Hero'			=> 'SH',
						'Surf'					=> 'SURF',
						'PaintBall'				=> 'PB',
						'Zmurka'				=> 'ZMRK',
						'Capture The Flag'		=> 'CTF',
						'de_dust2 only'			=> 'DD2',
						'Fun, Fy, Aim'			=> 'FUN',
						'CoD MW2'				=> 'CODMW2',
						'Promod 4'				=> 'PROMOD4',
						);
					
// DB
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'kid0r123456');
define('DB_NAME', 'dbkhost');

if (!$db=@mysql_connect(DB_HOST, DB_USER, DB_PASS))
{
	die ("<b>Doslo je do greske prilikom spajanja na MySQL...</b>");
}

if (!mysql_select_db(DB_NAME, $db))
{
	die ("<b>Greska prilikom biranja baze!</b>");
}

// Page title
if($page == "")			             {$title = "DBK Hosting";}
if($_GET['page'] == "server_info"){

  $ip_port	= explode(":", $_GET['ip']);
  $ip			= $ip_port[0];
  $port		= $ip_port[1];

  $srv = mysql_fetch_array(mysql_query("SELECT * FROM serverinfo WHERE ip='$ip' AND port='$port'"));
  
  $title = "$srv[hostname] - ArenaHosting";
}
if($_GET['page'] == "community_info"){
  
  $id = $_GET['id'];

  $comm = mysql_fetch_array(mysql_query("SELECT * FROM community WHERE id='$id'"));
  
  $title = "$comm[naziv] - ArenaHosting";
}
if($_SESSION['userid'] != ""){
	mysql_query("UPDATE users SET last_activity='".time()."' WHERE userid='".$_SESSION['userid']."'");
}
function time_ago($timestamp){
	$difference = time() - $timestamp;
	if($difference < 60){
		return $difference." sekundi";
	} else {
		$difference = round($difference / 60);
		if($difference < 60){
			return $difference." minuta";
		} else {
			$difference = round($difference / 60);
			if($difference < 24){
				return $difference." sati";
			} else {
				$difference = round($difference / 24);
				if($difference < 7){
					return $difference." dana";
				} else {
					$difference = round($difference / 7);
					return $difference."sedmica";
				}
			}
		}
	}
}
function time_remaining($timeLeft=0, $endTime=null) {

        /*check if 'endTime' parameter exists so we can calculate timeLeft
        else timeLeft will be '0' and function will return (0,0,0,0)*/
    if($endTime != null)
                $timeLeft = $endTime - time();
               
        /*if timeLeft value is bigger than 0 we have number
        that we can work with, else we return (0,0,0,0) */
    if($timeLeft > 0) {
       
                /*divide timeLeft value with number of seconds for 1 day:  1*24*60*60,
                remove calculated seconds from main timeLeft value*/
        $days = floor($timeLeft / 86400);
        $timeLeft = $timeLeft - $days * 86400;
               
                /*divide timeLeft value with number of seconds for 1 hr:  1*60*60,
                remove calculated seconds from main timeLeft value*/
        $hrs = floor($timeLeft / 3600);
        $timeLeft = $timeLeft - $hrs * 3600;
                 
                /*divide timeLeft value with number of seconds for 1 min:  1*60,
                remove calculated seconds from main timeLeft value */
        $mins = floor($timeLeft / 60);
               
                //what is left is seconds value
        $secs = $timeLeft - $mins * 60;
               
    }
        else
        {
                //return array with 0 values when there is not defined endTime
        return array(0, 0, 0, 0);
    }
       
        //return array with calculated values
    return array($days, $hrs, $mins, $secs);
}
function countdown($unix_timestamp, $msg){
	// get current unix timestamp
	$today = time();

	$difference = $unix_timestamp - $today;
	if ($difference < 0) $difference = 0;

	$days_left = floor($difference/60/60/24);
	$hours_left = floor(($difference - $days_left*60*60*24)/60/60); // broj sati preostalog dana(manje od 24)
	$minutes_left = floor(($difference - $days_left*60*60*24 - $hours_left*60*60)/60);


	if($difference > '0'){
		if($days_left != "0"){
			return $days_left.' d';
		}
		if($days_left == "0" && $hours_left != "0"){
			return $hours_left.' h';
		}
		if($days_left == "0" && $hours_left == "0"){
			return $minutes_left.' m';
		}
	}
	else {
		return '<span style="color:red">'.$msg.'</span>';
	}
}
function get_game_name($id){
	$s = mysql_fetch_array(mysql_query("SELECT * FROM igre WHERE id='$id'"));
	return $s['name'];
}

function get_mod_name($id){
	$s = mysql_fetch_array(mysql_query("SELECT * FROM modovi WHERE id='$id'"));
	return $s['ime'];
}








/********************** GAME PANEL ******************************/
/********************** GAME PANEL ******************************/
/*****************   Muharemović Haris  *************************/
/********************** GAME PANEL ******************************/
/********************** GAME PANEL ******************************/
function ssh_dodaj_server($server, $port, $username, $password, $new_user, $new_user_pw, $mod){
if (!function_exists("ssh2_connect")) return "SSH2 PHP extenzija nije instalirana";

include('phpseclib/SSH2.php');
$check_port_q = mysql_fetch_array(mysql_query("SELECT ssh_port FROM masine WHERE ip='$server'"));
	$ssh = new Net_SSH2($server, $check_port_q['ssh_port']);
	if (!$ssh->login($username, $password)) {
		exit('Login Failed');
	}
	function packet_handler($str)
	{
		echo $str;
	}
	
	


	$ssh->write("
	useradd $new_user\n mkdir /home/$new_user\n	screen -m -S ".$new_user."_instalacija\n   
	nice -n 19 rm -Rf /home/$new_user/* && cp -Rf $mod/* /home/$new_user && chown -Rf $new_user:$new_user /home/$new_user\n
	pkill -f ".$new_user."_instalacija\n
	"); 
	$ssh->setTimeout(5);
	echo $ssh->read('root@skilltest:~$');
	
	
	$ssh->enablePTY();
	$ssh->exec('sudo passwd '.$new_user);
	$ssh->read('password:');
	$ssh->write("$new_user_pw\n");
	$ssh->read('password:');
	$ssh->write("$new_user_pw\n");
	$ssh->read('passwd:');
	
	$ssh->disconnect();
	
	/*
		$ssh->enablePTY(); 
		$ssh->exec('passwd '.$new_user); 
		echo $ssh->read('password:'); 
		$ssh->write("$new_user_pw\n"); 
		$ssh->setTimeout(3); 
		$ssh->write("$new_user_pw\n"); 
		$ssh->setTimeout(3); 
		echo $ssh->read('password unchanged');
		
		$ssh->disconnect();
*/

return DA;
	
}



function start_server($server, $username, $password, $ftp_username, $komanda){
if (!function_exists("ssh2_connect")) return "SSH2 PHP extenzija nije instalirana";

include('phpseclib/SSH2.php');

$check_port_q = mysql_fetch_array(mysql_query("SELECT ssh_port FROM masine WHERE ip='$server'"));
	$ssh = new Net_SSH2($server, $check_port_q['ssh_port']);
	if (!$ssh->login($username, $password)) {
		exit('Login Failed');
	}
	function packet_handler($str)
	{
		echo $str;
	}
	
 	    

$ssh->write("
	screen -A -m -S $ftp_username\n   
	cd /home/$ftp_username\n
	$komanda\n
	"); 
	$ssh->setTimeout(5);
	echo $ssh->read('root@skilltest:~$');
    $ssh->disconnect();
return DA;
  
}
function stop_server($server, $username, $password, $ftp_username){
if (!function_exists("ssh2_connect")) return "SSH2 PHP extenzija nije instalirana";

include('phpseclib/SSH2.php');

$check_port_q = mysql_fetch_array(mysql_query("SELECT ssh_port FROM masine WHERE ip='$server'"));
	$ssh = new Net_SSH2($server, $check_port_q['ssh_port']);
	if (!$ssh->login($username, $password)) {
		exit('Login Failed');
	}
	function packet_handler($str)
	{
		echo $str;
	}
	    



$ssh->write("
	pkill -f $ftp_username\n   
	screen -wipe\n
	"); 
	$ssh->setTimeout(5);
	echo $ssh->read('root@skilltest:~$');
    $ssh->disconnect();
return DA;
    

}
function remove_server($server, $username, $password, $ftp_username){
if (!function_exists("ssh2_connect")) return "SSH2 PHP extenzija nije instalirana";

include('phpseclib/SSH2.php');

$check_port_q = mysql_fetch_array(mysql_query("SELECT ssh_port FROM masine WHERE ip='$server'"));
	$ssh = new Net_SSH2($server, $check_port_q['ssh_port']);
	if (!$ssh->login($username, $password)) {
		exit('Login Failed');
	}
	function packet_handler($str)
	{
		echo $str;
	}
	    
	echo $ssh->exec('rm -rf /home/'.$ftp_username);
	echo $ssh->exec('userdel '.$ftp_username);
    $ssh->disconnect();
return DA;
    

}
function reinstall_server($server, $username, $password, $ftp_username, $server_id, $mod){
if (!function_exists("ssh2_connect")) return "SSH2 PHP extenzija nije instalirana";
include('phpseclib/SSH2.php');

$check_port_q = mysql_fetch_array(mysql_query("SELECT ssh_port FROM masine WHERE ip='$server'"));
	$ssh = new Net_SSH2($server, $check_port_q['ssh_port']);
	if (!$ssh->login($username, $password)) {
		exit('Login Failed');
	}
	function packet_handler($str)
	{
		echo $str;
	}
	echo $ssh->exec('rm -rf /home/'.$ftp_username.'/*');
	echo $ssh->exec('cp -Rf '.$mod.'/* /home/'.$ftp_username);
	echo $ssh->exec("chown -Rf $ftp_username:$ftp_username /home/$ftp_username");
    $ssh->disconnect();
	
	
return DA;
	
}
function install_plugin($server, $username, $password, $ftp_username, $pluginid){

	$select_plugin =  mysql_fetch_array(mysql_query("SELECT amxx,sma FROM plugins WHERE id='$pluginid'"));
	$amxx_fajl = $select_plugin['amxx']; 
	$sma_fajl = $select_plugin['sma']; 
	
	$q1 = mysql_query("SELECT ftp_username,ftp_password,box FROM servers WHERE ftp_username='$ftp_username'") or die(mysql_error());
	$select_sve = mysql_fetch_array($q1);
	
	$box_name = mysql_fetch_array(mysql_query("SELECT ip FROM masine WHERE id='$select_sve[box]'"));
	
	$conftp 	= ftp_connect($box_name['ip']) or die("Ne mogu se spojiti sa FTP serverom.");
	$loginftp	= ftp_login($conftp, $select_sve['ftp_username'], $select_sve['ftp_password']) or die("Pogrešna autentikacija.");
	
	ftp_chdir($conftp, "/cstrike/addons/amxmodx/plugins/") or die('error0');
	ftp_put($conftp, $amxx_fajl, "plugins/$amxx_fajl", FTP_BINARY) or die('error1'.$amxx_fajl);


	ftp_chdir($conftp, "/cstrike/addons/amxmodx/scripting/");
    ftp_put($conftp, $sma_fajl, "plugins/$sma_fajl", FTP_BINARY);
	
	$local_file = "tmp_files/".time()."-PLUGIN-$select_sve[ftp_username].ini";
	
				
		$remote_file = "/cstrike/addons/amxmodx/configs/plugins.ini";
		ftp_chdir($conftp, "/cstrike/addons/amxmodx/configs/");
		if(ftp_get($conftp, $local_file, "plugins.ini", FTP_BINARY)){
			$filegt = file_get_contents($local_file);	
		} else {
			exit("ne mogu snimiti fajl");
		}
		$add_to_plugins = $filegt."\n$amxx_fajl";
		$otvori = fopen($local_file, "w");
		fwrite($otvori, $add_to_plugins);
		
		
		
		ftp_chdir($conftp, "/cstrike/addons/amxmodx/configs/");
		ftp_put($conftp, "plugins.ini", $local_file, FTP_BINARY);
	
	
return DA;
	
}
function sredi_samp($server, $username, $password, $ftp_username, $port, $players){

	/*
include('phpseclib/SSH2.php');

	$ssh = new Net_SSH2($server);
	if (!$ssh->login($username, $password)) {
		exit('Login Failed');
	}
	
	 
	echo $ssh->exec("chown -Rf $ftp_username:$ftp_username /home/$ftp_username");
    $ssh->disconnect();
	*/
	$q1 = mysql_query("SELECT ftp_username,ftp_password,box,ime_servera FROM servers WHERE ftp_username='$ftp_username'") or die(mysql_error());
	$select_sve = mysql_fetch_array($q1);
	
	$box_name = mysql_fetch_array(mysql_query("SELECT ip FROM masine WHERE id='$select_sve[box]'"));
	
	$conftp 	= ftp_connect($box_name['ip']) or die("Ne mogu se spojiti sa FTP serverom.");
	$loginftp	= ftp_login($conftp, $select_sve['ftp_username'], $select_sve['ftp_password']) or die("Pogrešna autentikacija.");
	
		
	$local_file = "tmp_files/".time()."-SAMP-$select_sve[ftp_username].cfg";
	
				
		$remote_file = "server.cfg";
		ftp_chdir($conftp, "");
		if(ftp_get($conftp, $local_file, "server.cfg", FTP_BINARY)){
			$filegt = file_get_contents($local_file);	
		} else {
			exit("ne mogu snimiti fajl");
		}
		
		
		// ovdje edit

		$filegt = str_replace("maxplayers 50", "maxplayers $players", $filegt); 
		$filegt	= str_replace("port 7777", "port $port", $filegt); 
		$filegt	= str_replace("hostname SA-MP 0.3 Server", "hostname $select_sve[ime_servera]", $filegt); 
		$filegt	= str_replace("rcon_password changeme", "rcon_password changeme123", $filegt); 
		// ovdje edit
		
		
		$otvori = fopen($local_file, "w");
		fwrite($otvori, $filegt);
		
		
	
		ftp_chdir($conftp, "");
		ftp_put($conftp, "server.cfg", $local_file, FTP_BINARY) or die("errorba");
		
		unlink($local_file);
	
return DA;
	
}
/********************** GAME PANEL ******************************/
/********************** GAME PANEL ******************************/
/*****************   Muharemović Haris  *************************/
/********************** GAME PANEL ******************************/
/********************** GAME PANEL ******************************/

function status_uplate($prioritet){
	 if($prioritet == "0"){
			  $status = "<span style=\"color:orange;\">Na čekanju</span>";
			} else if($prioritet == "1"){
			  $status = "<span style=\"color:lightgreen;\">Leglo</span>";
			} else if($prioritet == "2"){
			  $status = "<span style=\"color:red;\">Nije leglo</span>";
			} else if($prioritet == "3"){
			  $status = "<span style=\"color:red;\"><s>Iskorišteno</s></span>";
			}
			
			return $status;
}

function vrsta_uplate($vrsta){
			if($vrsta == "bank"){
			  $status = "Banka/Uplatnica";
			} else if($vrsta == "paypal"){
			  $status = "Paypal Transakcija";
			} 
			
			return $status;
}
function konvertuj($iznos, $valuta){
	if($valuta == 'DIN'){
		$iznos = $iznos/115;
	} else if($valuta == 'EUR'){ 
		$iznos = $iznos;
	} else if($valuta == 'KM'){
		$iznos = $iznos/1.956;
	} else if($valuta == 'MKD'){
		$iznos = $iznos/62;
	}
	return $iznos;
}
function get_ukupno_kes($userid){
$trenutno_stanje = mysql_query("SELECT id,iznos,valuta FROM uplate WHERE userid='$userid' and status='1'");

$ukupno = 0;
while($red = mysql_fetch_array($trenutno_stanje)){
	if($red['valuta'] == 'DIN'){
		$iznos = $red['iznos']/115;
	} else if($red['valuta'] == 'EUR'){ 
		$iznos = $red['iznos'];
	} else if($red['valuta'] == 'KM'){
		$iznos = $red['iznos']/1.956;
	} else if($red['valuta'] == 'MKD'){
		$iznos = $red['iznos']/62;
	}
	$ukupno = $ukupno+$iznos;
}
$ukupno_kes = number_format($ukupno, 2, '.', ' ');
return $ukupno_kes;
}

function izracunaj($uplataid){
$trenutno_stanje = mysql_query("SELECT id,iznos,valuta FROM uplate WHERE id='$uplataid'");

$ukupno = 0;
while($red = mysql_fetch_array($trenutno_stanje)){
	if($red['valuta'] == 'DIN'){
		$iznos = $red['iznos']/115;
	} else if($red['valuta'] == 'EUR'){ 
		$iznos = $red['iznos'];
	} else if($red['valuta'] == 'KM'){
		$iznos = $red['iznos']/1.956;
	} else if($red['valuta'] == 'MKD'){
		$iznos = $red['iznos']/62;
	}
	$ukupno = $ukupno+$iznos;
}
$ukupno_kes = number_format($ukupno, 2, '.', ' ');
$ukupno_kes = (float) $ukupno_kes;
return $ukupno_kes;
}

function getuser_info($userid){
$trenutno_stanje = mysql_query("SELECT * FROM users WHERE userid='$userid'");
$red = mysql_fetch_array($trenutno_stanje);
$info = $red['username'];
return $info; 

}
function valutiraj_posebno($userid){
$trenutno_stanje = mysql_query("SELECT id,iznos,valuta FROM uplate WHERE userid='$userid' and status='1'");

$ukupno = 0;
$arej = array();
while($red = mysql_fetch_array($trenutno_stanje)){
	if($red['valuta'] == 'DIN'){
		$iznos = $red['iznos']/115;
	} else if($red['valuta'] == 'EUR'){ 
		$iznos = $red['iznos'];
	} else if($red['valuta'] == 'KM'){
		$iznos = $red['iznos']/1.956;
	} else if($red['valuta'] == 'MKD'){
		$iznos = $red['iznos']/62;
	}

	$ukupno_kes = number_format($iznos, 2, '.', ' ');
	$red_iz = $red['id'];
	
	$arej[$red_iz] = $ukupno_kes; 
}


return $arej;
}
function kalkuliraj( $mathString )    {
    $mathString = trim($mathString);     
    $mathString = ereg_replace ('[^0-9\+-\*\/\(\) ]', '', $mathString);    
 
    $compute = create_function("", "return (" . $mathString . ");" );
    return 0 + $compute();
}
if(mysql_num_rows(mysql_query("SELECT ip FROM blocked_ips WHERE ip='".getenv('REMOTE_ADDR')."'"))!= 0){die('tvoja ip adresa je blokirana');}
?>