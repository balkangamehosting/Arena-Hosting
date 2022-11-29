<?php
defined("access") or die("Nedozvoljen pristup");
?>


<h3>Referal <span style="float:right;"> <a href="/admin_process.php?task=delete_referal">Izbrisi bodove sve</a> </span> </h3>
<?php
if(isset($_POST['check'])){
  $userid = $_POST['userid'];
  
  $kv = mysql_query("SELECT * FROM points WHERE userid='$userid'");
  $broj = mysql_num_rows($kv);
  $info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$userid'"));
  
  if($info['userid'] == ""){
  echo "
  <div class='ref_info'>
  Korisnik koga trazite ne postoji.
  </div><br />
  "; 
  } else {
  echo "
  <div class='ref_info'>
  Userid : $info[userid] <br /><br /> Username : $info[username] <br /><br /> Email : $info[email] <br /><br /> Bodova : <b><span style='color:green;'>$broj</span></b><br /><br />
  <a href='/admin_process.php?task=delete_points&userid=$info[userid]'>Izbrisi bodove</a>
  </div><br />
  ";
  }
}
?>

<form action="" method="POST">
<input type="text" name="userid"> <button class="submit" name="check">Proveri</button>
</form>

<h3>Server orders</h3>
<table class="morph">
<tr>
<th width="50">ID</th>
<th width="150">Name</th>
<th width="30">Plaćeno</th>
<th width="350">Game</th>
<th width="160">Email</th>
<th width="100">Status</th>
</tr>
<?php
$query_servers = mysql_query("SELECT * FROM servers ORDER BY id DESC");
while($row_servers = mysql_fetch_array($query_servers)){
$status = $row_servers['status'];
if($status == "0"){
  $status = "<span style=\"color:yellow;\">Waiting</span>";
} else if($status == "1"){
  $status = "<span style=\"color:green;\">Approved</span>";
} else if($status == "2"){
  $status = "<span style=\"color:red;\">Disapproved</span>";
} else {}

if(!empty($row_servers['uplatnica']) or $row_servers['pay_ref'] == "1"){
	$uplatnica = "<font color=green>DA</font>";
} else {
	$uplatnica = "<font color=red>NE</font>";
}

  echo "<tr><td><a href=\"/admin/server_review/".$row_servers['id']."\">#".$row_servers['id']."</a></td> <td>".$row_servers['name']." ".$row_servers['surname']." </td><td>[$uplatnica]</td> <td>".get_game_name($row_servers['game'])."</td> <td>".$row_servers['email']."</td> <td>$status</td>  </tr>";
}
?>
</table>

<br />