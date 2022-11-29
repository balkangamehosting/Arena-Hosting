<?php
ob_start();

if($_SESSION['userid'] == ""){
   die("<script> alert('You dont have acess'); document.location.href='/'; </script>");
}
?>

<div class="admin_bg">

<?php
$kv = mysql_query("SELECT * FROM points WHERE userid='$_SESSION[userid]'");
$broj = mysql_num_rows($kv);

$b_k_t = 100; // bodova koliko treba za server

$ostalo_jos = $b_k_t - $broj;
?>

<h3>Referal</h3>
<p>Skupi <?php echo $b_k_t; ?> bodova i osvoji free server od 26 slotva. <span style="float:right;">Ostalo jos <b><?php echo $ostalo_jos; ?></b> bodova.</span></p>

<div class="test_123_1">
<label>Link: </label>  <input type="text" onclick="this.select();" value="http://web3.loc/referal/give_point/<?php echo $_SESSION['userid']; ?>">
</div>

<br />

<table class="morph">
<tr>
<th>ID</th>
<th width="200">IP adresa</th>
<th width="300">Hostname</th>
<th>Vreme</th>
<?php
$query_poen = mysql_query("SELECT * FROM points WHERE userid='$_SESSION[userid]' ORDER BY id DESC");
while($poen = mysql_fetch_array($query_poen)){
$vreme = date("Y-m-d H:i:s", $poen['vreme']);
  echo "<tr><td>$poen[id]</td>  <td>$poen[ip_user]</td> <td>$poen[hostname]</td> <td>$vreme</td></tr>";
}
?>
</table>

</div>

<div class="footer_height_add"></div>
<br />