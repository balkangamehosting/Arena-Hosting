<?php
$ip_port	= explode(":", $_GET['ip']);
$ip			= $ip_port[0];
$port		= $ip_port[1];

$info = mysql_fetch_array(mysql_query("SELECT * FROM serverinfo WHERE ip='$ip' AND port='$port'"));

if($info['id'] == ""){
die("<script> alert('Server koji trazite ne postoji.'); document.location.href='/'; </script>");
}

// Igra servera
$igra = $info['game'];
if($igra == "cs"){
  $igra = "Counter-Strike 1.6";
}

// Status servera
$online = $info['online'];
if($online == "1"){
  $online = "Da";
} else {
   $online = "Ne";
}

// Naziv
$naziv = $info['hostname'];
  if(strlen($naziv) > 30){ 
          $naziv = substr($naziv,0,30); 
          $naziv .= "..."; 
     } 
// Dodao
$dodao = $info['added'];
if($dodao == ""){
  $dodao = "Nema";
} else {
  $dodao = $info['added'];
}

// Vlasnik
$vlasnik = $info['owner'];
if($vlasnik == ""){
  $vlasnik = "Nema <span class='gt_op_inf'><a href='/process.php?task=potvrdi_vlasnistvo&id=$info[id]'>[Potvrdi]</a></span>";
} else {
  $vlasnik = "$info[owner] <span class='gt_op_inf'><a href='/process.php?task=potvrdi_vlasnistvo&id=$info[id]'>[Potvrdi]</a></span>";
 }
 
// Prosek
$players = $info['playercount'];
  
$niz24 = explode(',' , $players);

$niz1 = substr($players , 36);
$niz12 = explode(',' , $niz1);

$suma = array_sum( $niz24 );
$suma1 = array_sum( $niz12 );

$prosek = round($suma / count( $niz24 ), 2);
$prosek12 = round($suma1 / count( $niz12 ), 2);

$infomap = $info['mapname'];
if(file_exists("/img/".$info['game']."/160x120/".$infomap)){
	$infomap = "/img/".$info['game']."/160x120/".$infomap;
} else {
	$infomap = "/img/noimage.jpg";
}
?>

<div class="admin_bg">




<div class="gt_title_srv">
<?php echo $info['hostname']; ?>
</div>

<?php if($_SESSION['userid'] == ""){} else { ?>
<?php if($_SESSION['username'] == $info['owner']){ ?>
<center><a href="#change_info" name="modal"><img style="margin-top:10px;" src="/img/serverinfo_btn.png"></a></center>
<?php } else {} } ?>

<br /><br />

<div class="gt_inf_map">
    <div class="gt_img">
	  <img style="width:155px;height:115px;" src="/img/cs/160x120/<?php echo "$info[mapname]"; ?>.jpg">
	  <!-- <img style="width:155px;height:115px;" src="<?php echo "$infomap"; ?>"> -->
	  
	  <br /><div class="space"></div> <span class="mapname"><center><?php echo $info['mapname']; ?></center></span>
	</div> 
</div>

<div class="gt_inf_chart">
    <div class="chart_img">
	<img style="width:242px;height:127px;" src="/chart/<?php echo "$ip:$port"; ?>">
	</div>
</div>

<div class="gt_ops_srv">


 <div style="padding:10px;">
  <div class="gt_ops_text">
 
 <div style="float:left;">
 <span class="gt_op_inf">Opste informacije</span> <br /><div class="space"></div>
 

 <table  width="340" style="font-size:12px;">

	 <tr><td  width="120"><strong>Naziv: </strong></td> <td  width="250"><?php echo $naziv; ?></td> </tr>
	 <tr><td><strong>IP adresa: </strong></td> <td><?php echo "$ip:$port"; ?></td> </tr>
	 <tr><td><strong>Igra: </strong></td> <td><?php echo $igra; ?></td> </tr>
	 <tr><td><strong>Status: </strong></td> <td><?php echo $online; ?></td> </tr>
	 <tr><td><strong>Rank: </strong></td> <td><?php echo $info['rank']; ?></td> </tr>
	 <tr><td><strong>Sajt: </strong></td> <td><span class="link"><?php echo "<a target='_blank' href='http://$info[forum]'>$info[forum]</a>"; ?></span></td> </tr>

 </table>
 </div>
 <div style="float:left;margin-left:20px;">
 <span style="background:none;" class="gt_op_inf">Dodatno</span> <br /><div class="space"></div>
  <table  width="240" style="font-size:12px;">
	 <tr><td width="120"><strong>Mapa: </strong></td> <td><?php echo $info['mapname']; ?></td> </tr>
	 <tr><td><strong>Igraci: </strong></td> <td><?php echo "$info[num_players]/$info[max_players]"; ?></td> </tr>
	 <tr><td><strong>Mod: </strong></td> <td><?php echo $info['gamemod']; ?></td> </tr>
	 <tr><td><strong>Dodao: </strong></td> <td><span style="color:#01c91c;"><?php echo $dodao; ?></td></span></td></tr>
	 <tr><td><strong>Vlasnik: </strong></td> <td><span style="color:#01c91c;"><?php echo $vlasnik; ?></td></span></td></tr>
	 <tr><td><strong>Last update: </strong></td> <td><span style="color:#01c91c;"><?php echo time_ago($info['last_update']); ?></span></td> </tr>
 </table>
 
 
 </div>

<br style="Clear:both"  />
 <br /><div class="space"></div>

 <span class="gt_op_inf">Informacije o igracima</span> <br /><div class="space"></div> 
 <strong>Igraca: </strong> <?php echo "$info[num_players]/$info[max_players]"; ?> <div class="space"></div>
 <strong>Prosecan broj igraca (12h): </strong> <?php echo $prosek12; ?> <div class="space"></div>
 <strong>Prosecan broj igraca (24h): </strong> <?php echo $prosek; ?> <div class="space"></div>
 
 <br /><div class="space"></div>
 
 <span class="gt_op_inf">Rank servera</span> <br /><div class="space"></div>
 <strong>Rank: </strong> <?php echo $info['rank']; ?> <div class="space"></div>
 <strong>Najbolji rank: </strong> <?php echo $info['best_rank']; ?> <div class="space"></div>
 <strong>Najgori rank: </strong> <?php echo $info['worst_rank']; ?> <div class="space"></div>
 
 </div>
 </div>
 
 
</div>

<br /><br />

<div class="banner">Banner</div><br />
<center><img src="/server_banner/<?php echo "$ip:$port"; ?>">
<br /> <div class="banners_link"><a href="#banners" name="modal">Prikazi sve banere</a></div></center>


<br />
 
 <?php
 $nk = mysql_query("SELECT * FROM players WHERE sid='$info[id]'");
 $pbr = mysql_num_rows($nk);
 
 if($pbr < 1){ 
   echo "<div class='nemap'>Trenutno nema igraca na ovom serveru.</div>";
 } else {
 ?>
 
 <span style="margin-left:20px;" class="gt_op_inf">Online igraci</span> <br /><div class="space"></div>
 <table style="text-align:left;" width="95%" class="morph">
 <tr>
 <th style="padding:0px 5px 0px 5px;">Nick</th>
 <th style="padding:0px 5px 0px 5px;">Score</th>
 <th style="padding:0px 5px 0px 5px;">Online</th>
 </tr>
 <?php
 $p_q = mysql_query("SELECT * FROM players WHERE sid='$info[id]'");
 while($p = mysql_fetch_array($p_q)){ 
   $playertime = ( is_numeric($p['time_online']) ) ? ceil($p['time_online']/60).' m' : $p['time_online'];
   echo "<tr>  <td>$p[nickname]</td> <td>$p[score]</td> <td>$playertime</td> </tr>";
 }
 
 }
 ?>
 
 </table>

</div>

<div class="space_menu"></div>
<br />

	<div id="boxes">

	<div id="change_info" class="window">
    <div class="modal-reset">
    <div class="modal-title">
    Izmeni informacije <br /><br />
	
    <form action="/process.php?task=change_info" method="POST">
    
	<div class="form_test">
	<label>Sajt/forum:</label> <input type="text" <?php if($info['forum'] == ""){ ?> placeholder="www.primer.com" <?php } else { ?> value="<?php echo $info['forum']; ?>" <?php } ?> name="forum" required="required"> <br /><br />
	<input type="hidden" name="srvid" value="<?php echo $info['id']; ?>">
	<label>Lokacija:</label>
					<select name="location" id="location">
						<?php foreach ($gt_allowed_countries as $locationfull => $locationsafe): ?>
						<option value="<?php echo $locationsafe; ?>"><?php echo $locationfull; ?></option>
						<?php endforeach; ?>
					</select>
	<br /><br />
	
	<label>Mod:</label>
					<select name="mod">
						<?php foreach($gt_allowed_mods as $modfull => $modsafe): ?>
						<option value="<?php echo $modsafe; ?>"><?php echo $modfull; ?></option>
						<?php endforeach; ?>
					</select>
	<br /><br />
	</div>
    <br /><br />
	<button class="sacuvaj">SACUVAJ</button>
    </form>
	<div class="close"><a href="#"class="close"/>X</a></div>
    </div>
    </div>
    </div> 
	
	</div>
	
	
	<div id="boxes-banners">
	<!-- Banners -->
	<div id="banners" class="window">
    <div class="modal-reset-banners">
    <div class="modal-title">
    

    Server banners <br /><br />
	
	<div class="test_banners">
	<center>
	<img src="/server_banner/<?php echo "$ip:$port"; ?>"> <br />
	<textarea cols="60" rows="1" title="HTML code" onclick="this.select()" readonly="readonly"><a href="http://tracker.arena-hosting.com/server_info/<?php echo "$ip:$port"; ?>" target="_blank"><img src="http://tracker.arena-hosting.com/server_banner/<?php echo "$ip:$port"; ?>" border="0"></a></textarea> <br />
	<textarea cols="60" rows="1" title="Forum code" onclick="this.select()" readonly="readonly">[url=http://tracker.arena-hosting.com/server_info/<?php echo "$ip:$port"; ?>][img]http://tracker.arena-hosting.com/server_banner/<?php echo "$ip:$port"; ?>[/img][/url]</textarea><br /><br /><br />
	
	<img src="/server_banner_red/<?php echo "$ip:$port"; ?>"> <br />
	<textarea cols="60" rows="1" title="HTML code" onclick="this.select()" readonly="readonly"><a href="http://tracker.arena-hosting.com/server_info/<?php echo "$ip:$port"; ?>" target="_blank"><img src="http://tracker.arena-hosting.com/server_banner_red/<?php echo "$ip:$port"; ?>" border="0"></a></textarea> <br />
	<textarea cols="60" rows="1" title="Forum code" onclick="this.select()" readonly="readonly">[url=http://tracker.arena-hosting.com/server_info/<?php echo "$ip:$port"; ?>][img]http://tracker.arena-hosting.com/server_banner_red/<?php echo "$ip:$port"; ?>[/img][/url]</textarea><br /><br /><br />
	
    <img src="/server_banner_blue/<?php echo "$ip:$port"; ?>"> <br />
	<textarea cols="60" rows="1" title="HTML code" onclick="this.select()" readonly="readonly"><a href="http://tracker.arena-hosting.com/server_info/<?php echo "$ip:$port"; ?>" target="_blank"><img src="http://tracker.arena-hosting.com/server_banner_blue/<?php echo "$ip:$port"; ?>" border="0"></a></textarea> <br />
	<textarea cols="60" rows="1" title="Forum code" onclick="this.select()" readonly="readonly">[url=http://tracker.arena-hosting.com/server_info/<?php echo "$ip:$port"; ?>][img]http://tracker.arena-hosting.com/server_banner_blue/<?php echo "$ip:$port"; ?>[/img][/url]</textarea><br /><br /><br />
	
    <img src="/server_banner_orange/<?php echo "$ip:$port"; ?>"> <br />
	<textarea cols="60" rows="1" title="HTML code" onclick="this.select()" readonly="readonly"><a href="http://tracker.arena-hosting.com/server_info/<?php echo "$ip:$port"; ?>" target="_blank"><img src="http://tracker.arena-hosting.com/server_banner_orange/<?php echo "$ip:$port"; ?>" border="0"></a></textarea> <br />
	<textarea cols="60" rows="1" title="Forum code" onclick="this.select()" readonly="readonly">[url=http://tracker.arena-hosting.com/server_info/<?php echo "$ip:$port"; ?>][img]http://tracker.arena-hosting.com/server_banner_orange/<?php echo "$ip:$port"; ?>[/img][/url]</textarea><br /><br /><br />
	
    <img src="/server_banner_purple/<?php echo "$ip:$port"; ?>"> <br />
	<textarea cols="60" rows="1" title="HTML code" onclick="this.select()" readonly="readonly"><a href="http://tracker.arena-hosting.com/server_info/<?php echo "$ip:$port"; ?>" target="_blank"><img src="http://tracker.arena-hosting.com/server_banner_purple/<?php echo "$ip:$port"; ?>" border="0"></a></textarea> <br />
	<textarea cols="60" rows="1" title="Forum code" onclick="this.select()" readonly="readonly">[url=http://tracker.arena-hosting.com/server_info/<?php echo "$ip:$port"; ?>][img]http://tracker.arena-hosting.com/server_banner_purple/<?php echo "$ip:$port"; ?>[/img][/url]</textarea><br /><br /><br />
		
	</center>
	</div>  
	  
    </div>
    </div>
    </div> 
	
	</div>