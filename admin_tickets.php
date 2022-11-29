<?php
defined("access") or die("Nedozvoljen pristup");

$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$_SESSION[userid]'"));

if($_GET['id']){
	$ide = $_GET['id'];
	$q = mysql_num_rows(mysql_query("SELECT id FROM tickets WHERE name='$_SESSION[userid]'"));
}

if($info['rank'] == "0" or $info['rank'] == ""){
   die("<script> alert('You dont have aces1s'); document.location.href='/'; </script>");
} else {
if($info['rank'] == "0" and $q == 0){
   die("<script> alert('You dont have acess2'); document.location.href='/'; </script>");

}
?>

<?php


if($_POST['add']){
	$text = mysql_real_escape_string(strip_tags($_POST['text']));
	$postoci = mysql_real_escape_string(strip_tags($_POST['percents']));
	
	$code = rand(11111111,9999999999);
	
	mysql_query("INSERT INTO kuponi (text,code,percent) VALUES ('$text','$code','$postoci')");
	
}
if($_GET['delete']){
	mysql_query("DELETE FROM kuponi WHERE id='$_GET[delete]'");
	header("Location: /admin/kupon");
}
if($_GET['add']){
	mysql_query("UPDATE kuponi SET home='".time()."' WHERE id='$_GET[add]'");
	header("Location: /admin/kupon");
}
?>

			

<?php
if($_GET['id']){
?>
<h3>Tiket broj #<?php echo $_GET['id']; ?><h3>
<?php
} else {
?>
<h3>Support tiketi<h3>
<table width="100%" class="morph">
<tr>

<th width="300">ID</th>
<th width="50">Osoba</th>
<th width="200">E-Mail</th>
<th width="100">Prioritet</th>
<th width="100">Datum</th>
</tr>

<?php
$k_q = mysql_query("SELECT * FROM tickets ORDER BY `read` ASC LIMIT 200") or die(mysql_error());

while($r = mysql_fetch_array($k_q)){
if(!is_numeric($r['name'])){
	$name = $r['name'];
} else {
$q = mysql_fetch_array(mysql_query("SELECT username FROM users WHERE userid='$r[name]'"));
$name = "<a style='color:white;' href='/user/".$q['username']."'>".$q['username']."</a>";
}
if($r['prosledio'] == '1'){$prosledio = '[prosleđen]'; } else {$prosledio = '';}
if($r['read'] == 0){$asd = "style='color:yellow;'";}else {$asd = "style='color:w;'";}

$prioritet = $r['prioritet'];

 if($prioritet == "0"){
			  $status = "<span style=\"color:lightgreen;\">Nije hitno</span>";
			} else if($prioritet == "1"){
			  $status = "<span style=\"color:orange;\">Normalni</span>";
			} else if($prioritet == "2"){
			  $status = "<span style=\"color:red;\">Hitno</span>";
			} else {}
	?>
	<tr>
		<td ><a <?php echo $asd; ?> href="/ticket/<?php echo $r['id']; ?>" >#<?php echo $r['id']; ?> -  [otvori tiket] <?php echo $prosledio; ?></a></td>
		<td><?php echo $name; ?></td>
		<td><?php echo $r['email']; ?></td>
		<td><?php echo $status; ?></td>
		<td><?php echo $r['date']; ?></td>
		</td>
	</tr>
	<?php
}
   
?>
</table>
<?php } ?>

</center>

</div>


<br />

<?php } ?>