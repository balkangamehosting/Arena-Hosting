<?php
ob_start();

if($_SESSION['userid'] == ""){
   die("<script> alert('You dont have acess'); document.location.href='/'; </script>");
}
?>

<div class="admin_bg">

<h3>Vase narudzbe</h3>
<style>
	a {
		color:white;
		text-decoration:none;
	}
</style>
<div style="width:400px;float:right;">
	<div class="blokba">Tiketi</div>
	<table>
	<?php
$query_servers = mysql_query("SELECT * FROM tickets WHERE name='$_SESSION[userid]' ORDER BY id DESC");
while($row_servers = mysql_fetch_array($query_servers)){



  echo "<tr style='font-size:12px;'> <td><a href='/ticket/$row_servers[id]'><span style='color:yellow;'>Tiket #$row_servers[id]</span> - ".substr($row_servers['text'], 0, 20)."... </a></td></tr>";
}
?>
	</table>

</div>
<div style="width:400px;">
	<div class="blokba">Aktivni računi</div>
	<table>
	<?php
$query_servers = mysql_query("SELECT * FROM servers WHERE userid='$_SESSION[userid]' and status='1' ORDER BY id DESC");
while($row_servers = mysql_fetch_array($query_servers)){
$status = $row_servers['status'];
  $status = "<span style=\"color:green;font-weight:bold;font-transform:uppercase;\">AKTIVNO</span>";


  echo "<tr style='font-size:12px;'> <td width='150'><a href=\"/review/".$row_servers['id']."\">".$row_servers['ime_servera']." </a></td> <td width='150'>".$row_servers['slots']." slotova</td> <td>$status</td> </tr>";
}
?>
	</table>

</div>
<div style="width:400px;">
	<div class="blokba">Narudžbe</div>
	<table>
	<?php
$query_servers = mysql_query("SELECT * FROM servers WHERE userid='$_SESSION[userid]' and status='0' ORDER BY id DESC");
while($row_servers = mysql_fetch_array($query_servers)){
$status = $row_servers['status'];
  $status = "<span style=\"color:green;font-weight:bold;font-transform:uppercase;\">NA ČEKANJU</span>";


  echo "<tr style='font-size:12px;'> <td width='150'><a href=\"/review/".$row_servers['id']."\">".$row_servers['ime_servera']." </a></td> <td width='150'>".$row_servers['slots']." slotova</td> <td>$status</td> </tr>";
}
?>
	</table>

</div>

</div>

<div class="footer_height_add"></div>
<br />