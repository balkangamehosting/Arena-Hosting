<?php
defined("access") or die("Nedozvoljen pristup");

$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$_SESSION[userid]'"));

if($info['rank'] != "1" or $info['rank'] == ""){
   die("<script> alert('You dont have acess'); document.location.href='/'; </script>");
} else {
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

			<form action="" method="POST" class="fatform">
					<input required="required" type="text" style="width:250px;" name="text" id="ip" placeholder="Promo tekst..." value="<?php echo htmlspecialchars($_POST['text']); ?>" />
					<select name="percents">
						<option value="10">10 %</option>
						<option value="20">20 %</option>
						<option value="30">30 %</option>
						<option value="40">40 %</option>
						<option value="50">50 %</option>
						<option value="60">60 %</option>
						<option value="70">70 %</option>
						<option value="80">80 %</option>
						<option value="90">90 %</option>
					</select>
					<small>* Automatsko generisanje kupon codea</small>
					<input class="submit_button" type="submit" style="background:#008a12;float:right;cursor:pointer;" name="add" value="Dodaj kupon" />
			</form>

<br />


<table width="100%" class="morph">
<tr>

<th width="300">Promo tekst</th>
<th width="50">Code</th>
<th width="200">Postotci</th>
<th width="100">Akcije</th>
</tr>

<?php
$k_q = mysql_query("SELECT * FROM kuponi ORDER BY id DESC");
while($r = mysql_fetch_array($k_q)){
	?>
	<tr>
		<td><?php echo $r['text']; ?></td>
		<td><?php echo $r['code']; ?></td>
		<td><?php echo $r['percent']; ?> %</td>
		<td><a href="/index.php?page=admin&p=admin_kupons&delete=<?php echo $r['id']; ?>"><font color=red>Obrisi</font></a><br />
		<a href="/index.php?page=admin&p=admin_kupons&add=<?php echo $r['id']; ?>"><font color=blue>Dodaj na pocetnu</font></a>
		</td>
	</tr>
	<?php
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