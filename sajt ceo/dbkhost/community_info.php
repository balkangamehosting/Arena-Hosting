<?php
$id = addslashes($_GET['id']);

$info = mysql_fetch_array(mysql_query("SELECT * FROM community WHERE id='$id'"));

$br_srv = mysql_query("SELECT * FROM community_servers WHERE comid='$id'");
$broj_servera = mysql_num_rows($br_srv);

// Prosek
$players = $info['playercount'];
  
$niz24 = explode(',' , $players);

$suma = array_sum( $niz24 );

$prosek = round($suma / count( $niz24 ), 2);

if($info['id'] == ""){
    die("<script> alert('Zajednica koju trazite ne postoji.'); document.location.href='/'; </script>");
} else {

?>

<div class="admin_bg">


<div class="gt_inf_chart">
    <div class="chart_img">
	<img style="width:242px;height:127px;" src="/community_chart/<?php echo "$id"; ?>">
	</div>
</div>


<div class="gt_title_srv">
<?php echo $info['naziv']; ?>
</div>

<br /><br />

<?php
if($info['owner'] == "$_SESSION[username]"){
?>

  <a href="#community_add" style="margin-left:25px;" class="edit_server" name="modal">Dodaj servere u zajednicu</a>  <a href="#edit_community" style="" class="edit_server" name="modal">Izmeni informacije</a>

<?php } else {} ?>

<br /><br />

<div class="gt_ops_srv">

<div style="padding:10px;">
 <span class="gt_op_inf">Opste informacije</span> <br /><div class="space"></div>
 
 <div class="gt_ops_text">
 <strong>Ime zajednice: </strong> <?php echo $info['naziv']; ?> <div class="space"></div>
 <strong>Sajt/forum: </strong> <a target="_blank" href="http://<?php echo $info['forum']; ?>"><?php echo $info['forum']; ?></a> <div class="space"></div>
 <strong>Vlasnik: </strong> <span style="color:#01c91c;"><?php echo $info['owner']; ?></span> <div class="space"></div>
 <strong>Broj servera: </strong> <?php echo $broj_servera; ?> <div class="space"></div>
 <strong>Ukupno igraca: </strong> 
 
 <?php
 $sql = "SELECT sum( num_players ) as `suma_igraca`, sum( max_players ) as `max_igraca`
 FROM `serverinfo`
 WHERE
 `id` IN (SELECT `srvid` FROM `community_servers` WHERE `comid` = '{$id}')";

 $tmp = mysql_fetch_assoc( mysql_query( $sql ) );
 echo "$tmp[suma_igraca]/$tmp[max_igraca]";
 ?>
 <div class="space"></div>
 
 <strong>Prosek igraca u toku dana:</strong> <?php echo $prosek; ?><div class="space"></div>
 
 <br /><div class="space"></div>
 
 <span class="gt_op_inf">O zajednici</span> <br /><div class="space"></div> 
 <?php echo $info['opis']; ?>
 </div>
 </div>

 </div>
 
   <br /><br />

<?php
$kte2 = mysql_query("SELECT * FROM community_servers WHERE comid='$id'");
$br_kt = mysql_num_rows($kte2);

if($br_kt < 1){
echo "<div class='nemap'>Trenutno nema dodatih servera.</div>";
} else {
?>   
   
<table width="95%" class="morph">
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
$kte = mysql_query("SELECT * FROM community_servers WHERE comid='$id'");
while($te = mysql_fetch_array($kte)){
$res = mysql_query("SELECT * FROM serverinfo WHERE id='$te[srvid]' ORDER BY rank_pts DESC");
while($srv = mysql_fetch_array($res)){
	  $naziv = $srv['hostname'];
      if(strlen($naziv) > 40){ 
          $naziv = substr($naziv,0,40); 
          $naziv .= "..."; 
	  }
   echo "<tr> <td>$srv[rank].</td> <td><img src='/img/$srv[game].png'></td>  <td><a href='/server_info/$srv[ip]:$srv[port]'>$naziv<a></td> <td><span id='broj_igraca'>$srv[num_players]</span>/$srv[max_players]</td> <td>$srv[ip]:$srv[port]</td> <td>$srv[gamemod]</td> <td><img src='/img/flags/$srv[location].png'></td> <td>$srv[mapname]</td></tr>";
}
}
}
?>
</table>
	
</div>

<div class="footer_height_add"></div><br />
<?php } ?>


	<div id="boxes">

	<div id="community_add" class="window">
    <div class="modal-reset">
    <div class="modal-title">
    Dodaj servere u zajednicu <br /><br />
	
	<?php
	$mk = mysql_query("SELECT * FROM serverinfo WHERE owner='$info[owner]'");
	$br1 = mysql_num_rows($mk);
	
	if($br1 < 1){
	echo "<div style='width:95%;color:#FFF;' class='nemap'>Jos niste vlasnik nijednog servera.</div>";
	} else {
	?>
	
    <table width="100%" style="color:#FFF;text-shadow:1px 1px 1px #000;" class="morph">
    <tr>
    <th>Rank</th>
    <th>Naziv</th>
    <th>Akcije</th>
	<?php
	$kveri = mysql_query("SELECT * FROM serverinfo WHERE owner='$info[owner]' ORDER by rank_pts DESC");
	while($k = mysql_fetch_array($kveri)){
	  $naziv = $k['hostname'];
      if(strlen($naziv) > 30){ 
          $naziv = substr($naziv,0,30); 
          $naziv .= "..."; 
	  }
	  echo "<tr> <td>$k[rank].</td> <td><a target='_blank' href='/server_info/$k[ip]:$k[port]'>$naziv</a></td>";
	  
	$tk = mysql_query("SELECT * FROM community_servers WHERE srvid='$k[id]'");
    $brtk = mysql_num_rows($tk);
    if($brtk > 0){
    ?>
	<td><a style='color:#FF0000;' href="/process.php?task=remove_comm&comid=<?php echo $id;  ?>&srvid=<?php echo $k['id']; ?>">Izbaci</a></td> </tr>
	<?php
    } else {	
	?>
	<td><a style='color:green;' href="/process.php?task=add_comm&comid=<?php echo $id;  ?>&srvid=<?php echo $k['id']; ?>">Ubaci</a></td> </tr>
	<?php
	}
	}
	?>
    </table>
	
	<?php } ?>
	
	<div class="close"><a href="#"class="close"/>X</a></div>
    </div>
    </div>
    </div> 
	
	
	<div id="edit_community" class="window">
    <div class="modal-reset">
    <div class="modal-title">
    Izmeni informacije <br /><br />
	
    <form action="/process.php?task=edit_community" method="POST">
	<input type="text" name="naziv" style="width:90%;" value="<?php echo $info['naziv']; ?>" required="required"> <br /><div class="space"></div> 
	<input type="text" name="forum" style="width:90%;" value="<?php echo $info['forum']; ?>" required="required"> <br /><div class="space"></div> 
	<textarea name="opis" style="width:90%;background:#000;border:solid 1px #235860;padding:5px;color:#FFF;font-weight:bold;font-family:Tahoma;font-size:11px;height:110px;" required="required"><?php echo $info['opis']; ?></textarea><br /><div class="space"></div> 
	<input type="hidden" name="id" value="<?php echo $id; ?>">
	<input class="submit_button" type="submit" style="background:#008a12;float:center;cursor:pointer;height:32px;border-radius:3px;" name="submit_server" value="Sacuvaj" />
				
	</form>
	
	<div class="close"><a href="#"class="close"/>X</a></div>
    </div>
    </div>
    </div>
	
	
	</div>