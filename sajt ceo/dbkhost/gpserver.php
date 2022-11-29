<?php
if($_SESSION['userid'] == ""){
   die("<script> alert('Ulogujte se prvo.'); document.location.href='/'; </script>");
}
?>
<?php 
	$id = mysql_real_escape_string(strip_tags($_GET['id']));
	
	$select = mysql_query("SELECT * FROM servers WHERE id='$id'");
	if(mysql_num_rows($select) == 0){exit("System error:)");}
	$select_fetch = mysql_fetch_array($select);
	if($_SESSION['userid'] != $select_fetch['userid'] and $info['rank'] == '0'){exit('System down:)');}
	
	$box_name = mysql_fetch_array(mysql_query("SELECT name,location,ip FROM masine WHERE id='$select_fetch[box]'"));
	
	$status = $select_fetch['status'];
	if($status == '0'){exit("error");}
	if($status == "1"){
		 $status = "<span style=\"color:lightgreen;\">Aktivan</span>";
	} else if($status == "2"){
		 $status = "<span style=\"color:red;\">Suspendovan</span>";
	} else {}
	
	
	$game_fetch = mysql_fetch_array(mysql_query("SELECT protocol FROM igre WHERE id='$select_fetch[game]'"));
	
	if($select_fetch['last_update'] > time()+15){
		$getuodate = $select_fetch['info_status'];
		$getexplode = explode("/--/", $getuodate);
		
		$data['server_'.$id]['gq_online'] = $getexplode[0];
		$data['server_'.$id]['gq_mapname'] = $getexplode[1];
		$data['server_'.$id]['gq_numplayers'] = $getexplode[2];
		$data['server_'.$id]['gq_hostname'] = $getexplode[1];
	} else {
		require_once('gameq.php');
		$servers = array('server_'.$id => array($game_fetch['protocol'], $box_name['ip'], $select_fetch['port']));
		$gq = new GameQ();
		$gq->addServers($servers);
		$gq->setOption('timeout', 200);
		$gq->setFilter('normalise');
		$gq->setFilter('sortplayers');
		$data = $gq->requestData();
		
		$info_status = $data['server_'.$id]['gq_online']."/--/".$data['server_'.$id]['gq_mapname']."/--/".$data['server_'.$id]['gq_numplayers']."/--/".$data['server_'.$id]['gq_hostname'];
		
		mysql_query("UPDATE servers SET last_update='".time()."', info_status='$info_status' WHERE id='$id'") or die(mysql_error());
	}
	
	# Live status
		
	
	
	if($data['server_'.$id]['gq_online'] == "1"){
		$live_status = "<span style=\"color:lightgreen;\">Online</span>";
		$live_map 	 = $data['server_'.$id]['gq_mapname'];
		$live_name 	 = $data['server_'.$id]['gq_hostname'];
		$live_players		= mysql_real_escape_string($data['server_'.$id]['gq_numplayers']);
		$live_max_players	= mysql_real_escape_string($data['server_'.$id]['gq_maxplayers']);
	} else {
		$live_status = "<span style=\"color:red;\">Offline</span>";
		$live_map 	 = "/";
		$live_name 	 = "/";
	}
?>

<h3 style="margin:0;"><?php echo $select_fetch['ime_servera']; ?></h3><br />

<div class="akcije">
	<ul>
			<li><a href="/gp/server/<?php echo $id; ?>"><img src="/img/serverinfo.png" />Server info</a></li>
			<li><a href="/gp/server/<?php echo $id; ?>/webftp"><img width="16" src="/img/folder.png" />Web FTP</a></li>
			<li><a  href="/gp/server/<?php echo $id; ?>/modovi" ><img width="16" src="/img/modovi.png" />Modovi</a></li>
			<li><a  href="/gp/server/<?php echo $id; ?>/plugini" ><img width="16" src="/img/plugins.png" />Plugini</a></li>
			<li><a  href="#reinstal" class="fancybox"><img width="16" src="/img/reinstal.png" />Reinstall</a></li>
			<li><a href="/gp/server/<?php echo $id; ?>/monitor"><img width="16" src="/img/monitor.png" />Grafik servera</a></li>
			<?php if($infoba['rank'] == '1'){
				if($data['server_'.$id]['gq_online'] == "0"){
			?>
			<li><a onClick="obrisi(<?php echo $id; ?>);" href="#"><img width="16" src="/img/close.png" />Obriši server</a></li>
			<?php } else { ?>
			<li><a  href="#"><img width="16" src="/img/close.png" />Prvo stopirajte server!</a></li>
			<?php } } ?>
		</ul>
		<br style="clear:both" />
</div>
<br />
<?php  include("gpserver$_GET[content].php"); ?>
</div>