<?php
        session_start();
        include("connect_db.php");
		
$ip_port	= explode(":", $_GET['ip']);
$ip			= $ip_port[0];
$port		= $ip_port[1];
		
		$info = mysql_fetch_array(mysql_query("SELECT * FROM serverinfo WHERE ip='$ip' AND port='$port'"));
		
		$name = $info['hostname'];

        if(strlen($name) > 30){ 
          $name = substr($name,0,30); 
          $name .= "..."; 
        }         
		
		$status = $info['online'];
		if($status == "1"){
		  $status = "Online";
		} else {
		  $status = "Offline";
		}
		
		$game = $info['game'];
		if($game = "cs"){
		   $game = "Counter-Strike 1.6";
		} else {}
		
		$mapa = $info['mapname'];
        if(strlen($mapa) > 10){ 
          $mapa = substr($mapa,0,10); 
          $mapa .= "..."; 
        }     		

		if($info['ip'] == ""){
		 $_SESSION['error'] = "Server banner doesn't exist , add server to get banner";
		 header("location:/index.php");
		 die();
		} else {
		
		$server_max_players = $info['max_players'];
		$server_playercount = $info['playercount'];
		$chart_x_fields		= $info['chart_updates'];
        $chart_x_replace	= "0,2,4,6,8,10,12,14,16,18,20,22,24";
		$chart_x_max		= $server_max_players;
	    $chart_data			= $server_playercount;
		
	    $chart_img			= imagecreatefrompng("http://chart.apis.google.com/chart?chf=bg,s,67676700&chxp=&chs=130x50&cht=lc&chco=FFFFFF&chds=0,$chart_x_max&chd=t:$chart_data&chdlp=b&chls=1&chm=B,068789,0,0,0,1");

		$server_location	= imagecreatefrompng("img/flags/$info[location].png");


        header('Content-type: image/png');
		
        $image = imagecreatefrompng("img/cs_banner_pink.png");
		imagecopy($image, $chart_img, 425, 35, 0, 0, 130, 50);
		#imagecopy($image, $server_location, 529, 113, 0, 0, 22, 15);
       
        $white = imagecolorallocate($image, 255, 255, 255);

        imagettftext($image, 8, 0, 213, 44, $white, 'fonts/arial.ttf', "$name");
		imagettftext($image, 8, 0, 213, 86, $white, 'fonts/arial.ttf', "$ip:$port");
		imagettftext($image, 7, 0, 238, 126, $white, 'fonts/arial.ttf', "$mapa");
        imagettftext($image, 7, 0, 340, 126, $white, 'fonts/arial.ttf', "$info[num_players]/$info[max_players]");
		imagettftext($image, 7, 0, 449, 126, $white, 'fonts/arial.ttf', "#$info[rank]");
		imagettftext($image, 7, 0, 535, 126, $white, 'fonts/arial.ttf', "$status");
		
        imagepng($image);
        imagedestroy($image);
		
		}
?>