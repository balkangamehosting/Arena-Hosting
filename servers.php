<?php
ob_start();
?>

<div class="admin_bg">


<?php
if($_SESSION['userid'] == ""){} else {
?>
			<form action="/process.php?task=add_server" method="POST" class="fatform">
					<select name="game" id="game">
						<?php foreach ($gt_allowed_games as $gamefull => $gamesafe): ?>
						<option value="<?php echo $gamesafe; ?>"><?php echo $gamefull; ?></option>
						<?php endforeach; ?>
					</select>

					<select name="location" id="location">
						<?php foreach ($gt_allowed_countries as $locationfull => $locationsafe): ?>
						<option value="<?php echo $locationsafe; ?>"><?php echo $locationfull; ?></option>
						<?php endforeach; ?>
					</select>

					<select name="mod">
						<?php foreach($gt_allowed_mods as $modfull => $modsafe): ?>
						<option value="<?php echo $modsafe; ?>"><?php echo $modfull; ?></option>
						<?php endforeach; ?>
					</select>

					<input type="text" name="ip" id="ip" placeholder="IP adresa" value="<?php echo htmlspecialchars($_POST['ip']); ?>" />

					<input type="text" name="port" id="port" placeholder="Port" value="<?php echo htmlspecialchars($_POST['port']); ?>" />

					<input class="submit_button" type="submit" style="background:#008a12;float:right;cursor:pointer;" name="submit_server" value="Dodaj server" />
				</p>
			</form>
<?php } ?>

<br />

<div class='ref_info'>Sva pitanja vezana za Gametracker mozete se obratiti na email <strong>itszensei@gmail.com</strong></div>

<br />

<?php
if(isset($_POST['trazi'])){
$ip = mysql_real_escape_string($_POST['ip']);

if($ip == ""){
die("<script> alert('Polje ne sme biti prazno'); document.location.href='/servers'; </script>");
} else {
die("<script> alert('Molimo vas sacekajte'); document.location.href='/server_info/$ip'; </script>");
}
}
?>

			<form action="" method="POST" class="fatform">
					<input type="text" style="width:250px;" name="ip" id="ip" placeholder="IP adresa" value="<?php echo htmlspecialchars($_POST['ip']); ?>" />

					<input class="submit_button" type="submit" style="background:#008a12;float:right;cursor:pointer;" name="trazi" value="Trazi server" />
			</form>

<br />


<table width="100%" class="morph">
<tr>
<th>Rank</th>
<th>Igra</th>
<th width="300">Naziv</th>
<th width="50">Igraca</th>
<th width="200">IP adresa</th>
<th>Mod</th>
<th>Lokacija</th>
<th width="100">Mapa</th>

<?php

   $kveri = mysql_query("SELECT * FROM serverinfo");
	/*Paginacija test CREDITS: Adam*/
	$broj_artikala = mysql_num_rows($kveri);
	if(isset($_GET['stranica'])){
		$page = preg_replace('#[^0-9]#i', '', $_GET['stranica']);
	} else {
		$page = 1;
	}
	//Podataka po stranici * kps *
	$kps = 10; //Broj podataka po stranici
	$zadnja = ceil($broj_artikala/$kps);

	if ($page < 1){
		$page = 1;	
	} elseif ($page > $zadnja){
		$page = $zadnja;	
	}

	$centar = "";
	$sub1 = $page - 1;
	$sub2 = $page - 2;
	$add1 = $page + 1;
	$add2 = $page + 2;
	if ($page == 1) {
	    $centar .= '<div class="pagination"><ul>';
		$centar .= '<li class="active"><a href="/servers/&stranica=' . $page . '">' . $page . '</a></li>';
		$centar .= '<li><a href="/servers/&stranica=' . $add1 . '">' . $add1 . '</a></li> ';
	} else if ($page == $zadnja) {
		$centar .= '<a href="/servers/&stranica=' . $sub1 . '">' . $sub1 . '</a> ';
		$centar .= '<li><span style="color:#999999;">' . $page . '</span></li>';
	} else if ($page > 2 && $page < ($zadnja - 1)) {
		$centar .= '<a href="/servers/&stranica=' . $sub2 . '">' . $sub2 . '</a> ';
		$centar .= '<a href="/servers/&stranica=' . $sub1 . '">' . $sub1 . '</a> ';
		$centar .= '<span style="color:#999999;">' . $page . '</span>';
		$centar .= '<a href="/servers/&stranica=' . $add1 . '">' . $add1 . '</a> ';
		$centar .= '<a href="/servers/&stranica=' . $add2 . '">' . $add2 . '</a> ';
	} else if ($page > 1 && $page < $zadnja) {
		$centar .= '<a href="/servers/&stranica=' . $sub1 . '">' . $sub1 . '</a> ';
		$centar .= '<span style="color:#999999;">' . $page . '</span>';
		$centar .= '<a href="/servers/&stranica=' . $add1 . '">' . $add1 . '</a> ';
	}
	$prvi = (($page-1)*$kps);
	$drugi = $kps;
	$kveri2 = mysql_query("SELECT * FROM serverinfo ORDER BY rank_pts DESC LIMIT $prvi,$drugi") or die(mysql_error());

	$prikazi = "";

	if ($zadnja != "1"){
		if ($page != 1) {
			$prethodna = $page - 1;
			$prikazi .=  '<div class="pagination"><ul><li> <a href="/servers/&stranica='.$prethodna.'">Prethodna</a> </li>';
		} 
		$prikazi .= '<li>'.$centar.'</li>';
		if ($page != $zadnja) {
			$sledeca = $page + 1;
			$prikazi .=  '<li><a href="/servers/&stranica='.$sledeca.'">Sledeca</a></li></ul></div>';
		} 
	}



$vreme = time() + 60;
while($srv = mysql_fetch_array($kveri2)){
  $name = $srv['hostname'];
  
  if(strlen($name) > 30){ 
          $name = substr($name,0,30); 
          $name .= "..."; 
     } 
  
  $ip = "$srv[ip]:$srv[port]";
  if($srv['online'] == '0'){
    $ip = "<span style='color:red;'>$srv[ip]:$srv[port]</span>";
  }
  
  echo "<tr> <td>$srv[rank].</td> <td><img src='/img/$srv[game].png'></td>  <td><a href='/server_info/$srv[ip]:$srv[port]'>$name</a></td> <td>$srv[num_players]/$srv[max_players]</td> <td>$ip</td> <td>$srv[gamemod]</td> <td><img src='/img/flags/$srv[location].png'></td> <td>$srv[mapname]</td></tr>";
}
?>
</table>

<center>
<?php
if(isset($prikazi) && !empty($prikazi)) {
?>
<div class="pagination"><?php echo $prikazi; ?></div>
<?php
}
?>
</center>

</div>

<div class="top10_best">
<table class="top_tbl">
<tr>
<th width="47"></th>
<th width="30"></th>
<th width="180"></th>
</tr>

<?php
$top_k = mysql_query("SELECT * FROM serverinfo WHERE online='1' ORDER BY rank_pts DESC LIMIT 10");
while($top = mysql_fetch_array($top_k)){
  $name = $top['hostname'];
  
  if(strlen($name) > 23){ 
          $name = substr($name,0,23); 
          $name .= "..."; 
     } 
  $location = $top['location'];
  $game = $top['game'];

   echo "<tr> <td style='float:right;'><img src='/img/$game.png'></td>  <td><img style='float:right;' src='/img/flags/$location.png'></td>  <td style='padding-left:10px;'><a href='/server_info/$top[ip]:$top[port]'>$name</a></td> </td> </tr>";  
}
?>

</table>
</div>


<div class="top10_best_random">
<table class="top_tbl">
<tr>
<th width="47"></th>
<th width="30"></th>
<th width="180"></th>
</tr>

<?php
$top_k = mysql_query("SELECT * FROM serverinfo WHERE online='1' ORDER BY rand() DESC LIMIT 10");
while($top = mysql_fetch_array($top_k)){
  $name = $top['hostname'];
  
  if(strlen($name) > 23){ 
          $name = substr($name,0,23); 
          $name .= "..."; 
     } 
  $location = $top['location'];
  $game = $top['game'];

   echo "<tr> <td style='float:right;'><img src='/img/$game.png'></td>  <td><img style='float:right;' src='/img/flags/$location.png'></td>  <td style='padding-left:10px;'><a href='/server_info/$top[ip]:$top[port]'>$name</a></td> </td> </tr>";  
}
?>

</table>
</div>


<div class="top10_best_last">
<table class="top_tbl">
<tr>
<th width="47"></th>
<th width="30"></th>
<th width="180"></th>
</tr>

<?php
$top_k = mysql_query("SELECT * FROM serverinfo WHERE online='1' ORDER BY id DESC LIMIT 10");
while($top = mysql_fetch_array($top_k)){
  $name = $top['hostname'];
  
  if(strlen($name) > 23){ 
          $name = substr($name,0,23); 
          $name .= "..."; 
     } 
  $location = $top['location'];
  $game = $top['game'];

   echo "<tr> <td style='float:right;'><img src='/img/$game.png'></td>  <td><img style='float:right;' src='/img/flags/$location.png'></td>  <td style='padding-left:10px;'><a href='/server_info/$top[ip]:$top[port]'>$name</a></td> </td> </tr>";  
}
?>

</table>
</div>

<div class="space_menu"></div>
<br />