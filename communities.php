<?php
ob_start();
?>

<div class="admin_bg">

<br />

<div class='ref_info'>Sva pitanja vezana za Gametracker mozete se obratiti na email <strong>itszensei@gmaill.com</strong></div>

<br />


<table width="100%" class="morph">
<tr>
<th>Rank</th>
<th width="300">Naziv</th>
<th width="100">Broj servera</th>
<th width="200">Igraca</th>
<th>Sajt/forum</th>
<th>Vlasnik</th>

<?php

    $kveri = mysql_query("SELECT * FROM community") or die(mysql_error());
	/*Paginacija test CREDITS: Adam*/
	$broj_artikala = mysql_num_rows($kveri);
	if(isset($_GET['stranica'])){
		$page = preg_replace('#[^0-9]#i', '', $_GET['stranica']);
	} else {
		$page = 1;
	}
	//Podataka po stranici * kps *
	$kps = 15; //Broj podataka po stranici
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
		$centar .= '<li class="active"><a href="/communities/&stranica=' . $page . '">' . $page . '</a></li>';
		$centar .= '<li><a href="/communities/&stranica=' . $add1 . '">' . $add1 . '</a></li> ';
	} else if ($page == $zadnja) {
		$centar .= '<a href="/communities/&stranica=' . $sub1 . '">' . $sub1 . '</a> ';
		$centar .= '<li><span style="color:#999999;">' . $page . '</span></li>';
	} else if ($page > 2 && $page < ($zadnja - 1)) {
		$centar .= '<a href="/communities/&stranica=' . $sub2 . '">' . $sub2 . '</a> ';
		$centar .= '<a href="/communities/&stranica=' . $sub1 . '">' . $sub1 . '</a> ';
		$centar .= '<span style="color:#999999;">' . $page . '</span>';
		$centar .= '<a href="/communities/&stranica=' . $add1 . '">' . $add1 . '</a> ';
		$centar .= '<a href="/communities/&stranica=' . $add2 . '">' . $add2 . '</a> ';
	} else if ($page > 1 && $page < $zadnja) {
		$centar .= '<a href="/communities/&stranica=' . $sub1 . '">' . $sub1 . '</a> ';
		$centar .= '<span style="color:#999999;">' . $page . '</span>';
		$centar .= '<a href="/communities/&stranica=' . $add1 . '">' . $add1 . '</a> ';
	}
	$prvi = (($page-1)*$kps);
	$drugi = $kps;
	$kveri2 = mysql_query("SELECT * FROM community ORDER BY rank_pts DESC LIMIT $prvi,$drugi") or die(mysql_error());

	$prikazi = "";

	if ($zadnja != "1"){
		if ($page != 1) {
			$prethodna = $page - 1;
			$prikazi .=  '<div class="pagination"><ul><li> <a href="/communities/&stranica='.$prethodna.'">Prethodna</a> </li>';
		} 
		$prikazi .= '<li>'.$centar.'</li>';
		if ($page != $zadnja) {
			$sledeca = $page + 1;
			$prikazi .=  '<li><a href="/communities/&stranica='.$sledeca.'">Sledeca</a></li></ul></div>';
		} 
	}



$vreme = time() + 60;
$i = 0;
while($srv = mysql_fetch_array($kveri2)){
$i++;

  $name = $srv['naziv'];
  $id = $srv['id'];
  
  if(strlen($name) > 30){ 
          $name = substr($name,0,30); 
          $name .= "..."; 
     } 
  
 $sql = "SELECT sum( num_players ) as `suma_igraca`, sum( max_players ) as `max_igraca`
 FROM `serverinfo`
 WHERE
 `id` IN (SELECT `srvid` FROM `community_servers` WHERE `comid` = '{$id}')";

 $tmp = mysql_fetch_assoc( mysql_query( $sql ) );
 
 $sql_new = mysql_query("SELECT * FROM community_servers WHERE comid='{$id}'");
 $sql_num = mysql_num_rows($sql_new);
 $broj_igraca = $tmp['suma_igraca'];
 $max_igraca = $tmp['max_igraca'];
 if($broj_igraca == ""){ $broj_igraca = "0"; } else {} 
 if($max_igraca == ""){ $max_igraca = "0"; } else {} 
  
 if($sql_num > 1){ echo "<tr> <td>$i.</td> <td><a href='/community_info/$srv[id]'>$name</a></td> <td>$sql_num</td> <td>$broj_igraca/$max_igraca</td> <td><a target='_blank' href='http://$srv[forum]'>$srv[forum]</a></td> <td>$srv[owner]</td></tr>"; } else { $i = $i-1; }
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

<div class="footer_height_add"></div>