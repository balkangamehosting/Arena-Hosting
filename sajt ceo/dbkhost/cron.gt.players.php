<?php 
include("connect_db.php");

$chars = array();
$start = date("H")+2;
for($i = 0; $i < 12; $i++){$chars[] = str_pad( ($start+2*$i)%24, 2, '0', STR_PAD_LEFT);}
$chart_updates = '|' . implode( '|', $chars);


$server_query	= mysql_query("SELECT id,ip,port,game,rank_pts,playercount FROM serverinfo ORDER BY rank_pts DESC");
while($server_row = mysql_fetch_assoc($server_query)){
	$server_id					= $server_row['id'];
	$server_ip					= $server_row['ip'];
	$server_port				= $server_row['port'];
	$server_game				= $server_row['game'];
	$server_rank_pts			= $server_row['rank_pts'];
	$server_playercount			= $server_row['playercount'];
	
	require_once("gameq.php");
	$servers = array('server_'.$server_id => array($server_game, $server_ip, $server_port));
	$gq = new GameQ();
	$gq->addServers($servers);
	$gq->setOption('timeout', 200);
	$gq->setFilter('normalise');
	$gq->setFilter('sortplayers');
	$data = $gq->requestData();
	

	if($data['server_'.$server_id]['gq_online'] == "1"){
		$num_players		= mysql_real_escape_string($data['server_'.$server_id]['gq_numplayers']);
		$max_players		= mysql_real_escape_string($data['server_'.$server_id]['gq_maxplayers']);
		
		$rank_pts			= $server_rank_pts + ($num_players/$max_players);

		$igraci = mysql_real_escape_string($data['server_'.$server_id]['gq_numplayers']);
        if($igraci == "0")       {$igraci = "00";}
		if($igraci == "1")       {$igraci = "01";}
		if($igraci == "2")       {$igraci = "02";}
		if($igraci == "3")       {$igraci = "03";}
		if($igraci == "4")       {$igraci = "04";}
		if($igraci == "5")       {$igraci = "05";}
		if($igraci == "6")       {$igraci = "06";}
		if($igraci == "7")       {$igraci = "07";}
		if($igraci == "8")       {$igraci = "08";}
		if($igraci == "9")       {$igraci = "09";}
		
		$server_playercount	= substr($server_playercount, 3);
		$server_playercount	= $server_playercount.",".$igraci;
			

		$update_query		= mysql_query("UPDATE serverinfo SET num_players='$num_players', max_players='$max_players', playercount='$server_playercount', chart_updates='$chart_updates', last_chart_update='$timestamp', rank_pts='$rank_pts' WHERE id='$server_id'");
	} else {
		$server_playercount		= substr($server_playercount,3);
		$server_playercount		= $server_playercount.",00";
		$update_query			= mysql_query("UPDATE serverinfo SET online='0', playercount='$server_playercount', last_chart_update='$timestamp' WHERE id='$server_id'");
	}
}
