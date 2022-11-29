<?php 
include("connect_db.php");

$server_query	= mysql_query("SELECT id,ip,port,game FROM serverinfo WHERE UNIX_TIMESTAMP()-last_update>180 ORDER BY rank_pts DESC");
while($server_row = mysql_fetch_assoc($server_query)){
	$server_id					= $server_row['id'];
	$server_ip					= $server_row['ip'];
	$server_port				= $server_row['port'];
	$server_game				= $server_row['game'];
	$last_update                = time();
	
	require_once('gameq.php');
	$servers = array('server_'.$server_id => array($server_game, $server_ip, $server_port));
	$gq = new GameQ();
	$gq->addServers($servers);
	$gq->setOption('timeout', 200);
	$gq->setFilter('normalise');
	$gq->setFilter('sortplayers');
	$data = $gq->requestData();
	

	if($data['server_'.$server_id]['gq_online'] == "1"){
		$hostname			= mysql_real_escape_string($data['server_'.$server_id]['gq_hostname']);
		$mapname			= mysql_real_escape_string($data['server_'.$server_id]['gq_mapname']);
		$num_players		= mysql_real_escape_string($data['server_'.$server_id]['gq_numplayers']);
		$max_players		= mysql_real_escape_string($data['server_'.$server_id]['gq_maxplayers']);
		$players			= $data['server_'.$server_id]['players'];
		
		$update_query		= mysql_query("UPDATE serverinfo SET online='1', hostname='$hostname', mapname='$mapname', num_players='$num_players', max_players='$max_players', last_update='$last_update' WHERE id='$server_id'");
		$del_player_query	= mysql_query("DELETE FROM players WHERE sid='$server_id'");
		foreach ($players as $player) {
			$player_nickname		= mysql_real_escape_string($player['gq_name']);
			$player_score			= mysql_real_escape_string($player['gq_score']);
			$player_time			= mysql_real_escape_string($player['time']);
			$player_nickname		= (!empty($player_nickname)) ? $player_nickname : 'anonymous';
			if(!is_numeric($player_time)){$player_time = '/';}
			$insert_player_query	= mysql_query("INSERT INTO players (id,nickname,score,time_online,mapname,sid) VALUES ('','$player_nickname','$player_score','$player_time','$mapname','$server_id')");
		}
	} else {
		$update_query		= mysql_query("UPDATE serverinfo SET online='0',num_players='0' WHERE id='$server_id'");
		$del_player_query	= mysql_query("DELETE FROM players WHERE sid='$server_id'");
	}
}
?>