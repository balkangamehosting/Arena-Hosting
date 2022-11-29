<?php 
include("connect_db.php");

$server_rank = 1;
// rank_pts+0 = order fix
$server_query	= mysql_query("SELECT * FROM serverinfo ORDER BY rank_pts DESC");
while($server_row = mysql_fetch_assoc($server_query)){
	$server_id		= $server_row['id'];
	$rank           = $server_row['rank'];
	$best_rank      = $server_row['best_rank'];
	$worst_rank     = $server_row['worst_rank'];
	
	$update_query	= mysql_query("UPDATE serverinfo SET rank='$server_rank' WHERE id='$server_id'");
	$server_rank++;
	
	$testrank++;
	
	if($best_rank == "" OR $best_rank =="0"){
	  mysql_query("UPDATE serverinfo SET best_rank='$testrank' WHERE id='$server_id'");
	} else if($testrank < $best_rank){
	  mysql_query("UPDATE serverinfo SET best_rank='$testrank' WHERE id='$server_id'");
	}
	
    if($worst_rank == "" OR $worst_rank =="0"){
	  mysql_query("UPDATE serverinfo SET worst_rank='$testrank' WHERE id='$server_id'");
	} else if($testrank > $worst_rank){
	  mysql_query("UPDATE serverinfo SET worst_rank='$testrank' WHERE id='$server_id'");
	}	
	

	
}