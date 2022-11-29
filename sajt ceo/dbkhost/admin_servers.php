<?php
defined("access") or die("Nedozvoljen pristup");

$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$_SESSION[userid]'"));

if($info['rank'] == "0" or $info['rank'] == ""){
   die("<script> alert('You dont have acess'); document.location.href='/'; </script>");
} else {
?>

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
<th width="">Akcije</th>
</tr>

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
		$centar .= '<li class="active"><a href="/admin/servers/&stranica=' . $page . '">' . $page . '</a></li>';
		$centar .= '<li><a href="/admin/servers/&stranica=' . $add1 . '">' . $add1 . '</a></li> ';
	} else if ($page == $zadnja) {
		$centar .= '<a href="/admin/servers/&stranica=' . $sub1 . '">' . $sub1 . '</a> ';
		$centar .= '<li><span style="color:#999999;">' . $page . '</span></li>';
	} else if ($page > 2 && $page < ($zadnja - 1)) {
		$centar .= '<a href="/admin/servers/&stranica=' . $sub2 . '">' . $sub2 . '</a> ';
		$centar .= '<a href="/admin/servers/&stranica=' . $sub1 . '">' . $sub1 . '</a> ';
		$centar .= '<span style="color:#999999;">' . $page . '</span>';
		$centar .= '<a href="/admin/servers/&stranica=' . $add1 . '">' . $add1 . '</a> ';
		$centar .= '<a href="/admin/servers/&stranica=' . $add2 . '">' . $add2 . '</a> ';
	} else if ($page > 1 && $page < $zadnja) {
		$centar .= '<a href="/admin/servers/&stranica=' . $sub1 . '">' . $sub1 . '</a> ';
		$centar .= '<span style="color:#999999;">' . $page . '</span>';
		$centar .= '<a href="/admin/servers/&stranica=' . $add1 . '">' . $add1 . '</a> ';
	}
	$prvi = (($page-1)*$kps);
	$drugi = $kps;
	$kveri2 = mysql_query("SELECT * FROM serverinfo ORDER BY rank_pts DESC LIMIT $prvi,$drugi") or die(mysql_error());

	$prikazi = "";

	if ($zadnja != "1"){
		if ($page != 1) {
			$prethodna = $page - 1;
			$prikazi .=  '<div class="pagination"><ul><li> <a href="/admin/servers/&stranica='.$prethodna.'">Prethodna</a> </li>';
		} 
		$prikazi .= '<li>'.$centar.'</li>';
		if ($page != $zadnja) {
			$sledeca = $page + 1;
			$prikazi .=  '<li><a href="/admin/servers/&stranica='.$sledeca.'">Sledeca</a></li></ul></div>';
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
  
  echo "<tr> <td>$srv[rank].</td> <td><img src='/img/$srv[game].png'></td>  <td><a href='/server_info/$srv[ip]:$srv[port]'>$name</a></td> <td>$srv[num_players]/$srv[max_players]</td> <td>$ip</td> <td>$srv[gamemod]</td> <td><img src='/img/flags/$srv[location].png'></td> <td>$srv[mapname]</td>  <td><a href='/admin_process.php?task=delete_server&id=$srv[id]' title='Obrisi server'><img src='/img/btn_del.png'></a> <a title='Restartuj rank' href='/admin_process.php?task=reset_server&id=$srv[id]'><img src='/img/reset_img.png'></a>  <a title='Edituj server' href='/admin/server_edit/$srv[id]'><img src='/img/Edit.png'></a> </td></tr>";
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


<br />

<?php } ?>