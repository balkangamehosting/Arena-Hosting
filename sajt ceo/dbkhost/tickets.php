<?php


$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$_SESSION[userid]'"));

if($_GET['id']){
	$ide = $_GET['id'];
	$qba = mysql_num_rows(mysql_query("SELECT id FROM tickets WHERE name='$_SESSION[userid]'"));
}

if($_SESSION['userid'] == ""){
   die("<script> alert('You dont have acess'); document.location.href='/'; </script>");

} 
?>



			



<h3>Support tiketi<h3>
<table width="100%" class="morph">
<tr>

<th width="300">ID</th>
<th width="50">Osoba</th>
<th width="200">E-Mail</th>
<th width="100">Datum</th>
</tr>

<?php
$k_q = mysql_query("SELECT * FROM tickets WHERE name='$_SESSION[userid]' ORDER BY id DESC LIMIT 50") or die(mysql_error());

while($r = mysql_fetch_array($k_q)){
if(!is_numeric($r['name'])){
	$name = $r['name'];
} else {
$q = mysql_fetch_array(mysql_query("SELECT username FROM users WHERE userid='$r[name]'"));
$name = "<a style='color:white;' href='/user/".$q['username']."'>".$q['username']."</a>";
}
if($r['read'] == 0){$asd = "style='color:yellow;'";}else {$asd = "style='color:w;'";}
	?>
	<tr>
		<td ><a <?php echo $asd; ?> href="/ticket/<?php echo $r['id']; ?>" >#<?php echo $r['id']; ?> -  [otvori tiket]</a></td>
		<td><?php echo $name; ?></td>
		<td><?php echo $r['email']; ?></td>
		<td><?php echo $r['date']; ?></td>
		</td>
	</tr>
	<?php
}
   
?>
</table>



</div>


<br />

