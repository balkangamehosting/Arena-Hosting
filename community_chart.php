<?php 
include("connect_db.php");

$id = addslashes($_GET['id']);
	
$server_query	= mysql_query("SELECT * FROM community WHERE id='$id'");
$server_row		= mysql_fetch_assoc($server_query);

$sql = "SELECT sum( num_players ) as `suma_igraca`, sum( max_players ) as `max_igraca`
 FROM `serverinfo`
 WHERE
 `id` IN (SELECT `srvid` FROM `community_servers` WHERE `comid` = '{$id}')";

$tmp = mysql_fetch_assoc( mysql_query( $sql ) );

$chart_x_fields		= $server_row['chart_updates'];
$chart_x_replace	= "0,2,4,6,8,10,12,14,16,18,20,22,24";
$chart_x_max		= $tmp['max_igraca'];
$chart_data			= $server_row['playercount'];
$chart_url			= "http://chart.apis.google.com/chart?chf=bg,s,67676700&chxl=0:$chart_x_fields&chxp=$chart_x_replace&chxr=0,0,24|1,0,$chart_x_max&chxt=x,y&chs=260x150&cht=lc&chco=FFFFFF&chds=0,$chart_x_max&chd=t:$chart_data&chdlp=b&chg=16,16,0,0&chls=2&chm=B,068789,0,0,0,1";

header('Content-Type: image/png');
$im = imagecreatefrompng($chart_url);
imagealphablending($im, false);
imagesavealpha($im, true);
imagepng($im);
imagedestroy($im);
?>