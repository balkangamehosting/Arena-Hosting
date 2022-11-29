<?php
ob_start();
$id = addslashes($_GET['id']);
session_start();
$start = microtime();
include_once("connect_db.php");

$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$_SESSION[userid]'"));
$row = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$id'"));


?>

<?php
if($row['id'] == ""){
   die("<script> alert('Server doesn't exist'); document.location.href='/'; </script>");
} else {
?>

<div class="admin_bg">
<div style="float:right;width:400px;">
<?php
	if($row['pay_ref'] == '1'){
		echo "<div style='color:green;background:black;border:solid 1px green;padding:10px;width:150px;text-align:center;'>Plaćeno bodovima! </div>";
	} else {
?>
	<a style="color:orange;text-decoration:none;"  href="/activate/<?php echo $id; ?> ">Aktiviraj drugim putem?</a>
	<h3>Uplatnica</h3>
	<?php
		if(!empty($row['uplatnica'])){
			// Prikaz uplatnice
			?>
			<img style="padding:2px;border:solid 1px #02A0A2;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;" src="/<?php echo $row['uplatnica']; ?>" width="300"/>
			<?php
		} else {
			// Dodavanje uplatnice
		}
	?>
	<form class="test_class" method="POST" enctype="multipart/form-data" action="/process.php?task=nova_uplatnica&serverid=<?php echo $id; ?>">
		<label><br />Uploadujte novu sliku uplatnice:</label><br /><br /> <input type="file" name="uplatnica" accept="image/jpeg,image/png" required="required"> <br /><div class="space_contact1"></div> <br />
		<button class="edit_server">Upload!</button>
	</form>
	<br style="clear:both" />
	<?php } ?>
	<br style="clear:both" />
</div>

<h3>Narudzba novog servera</h3>
<style>
label {width:130px !important; float:left;}
</style>
<div style="font-family:TAHOMA;font-size:12px;font-weight:bold;">

<label>Igra:</label> <?php echo get_game_name($row['game']); ?> <br /><br />
<label>Lokacija:</label> <?php echo $row['city']; ?> <br /><br />
<label>Period:</label> <?php echo $row['country']; ?> mjesec<br /><br />
<label>Cijena:</label> <?php echo $row['price']; ?> <br /><br />


</div>

<h3>Server informacije</h3>

<div style="font-family:TAHOMA;font-size:12px;font-weight:bold;">
<label>Placanje:</label> <?php echo $row['payment']; ?> <br /><br />
<label>Slotova:</label> <?php echo $row['slots']; ?> <br /><br />
<label>Datum narudzbe:</label> <?php echo date("d.m.Y", $row['datum_narudzbe']); ?> <br /><br />

</div>


<h3>ODGOVORI</h3>
 
 <form action="/process.php?task=comment" class="iform" id="iform" method="POST">
 <input type="text" name="message" required="required" placeholder="Upisite odgovor..">
 <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
 <input type="hidden" name="id" value="<?php echo $id; ?>">
 </form>
 
 <br />
 
 <?php
 $kveric = mysql_query("SELECT * FROM serv_comm WHERE servid='$id' ORDER BY id DESC");
 while($com = mysql_fetch_array($kveric)){
   $username = $com['username'];
   $message = $com['message'];
   $time = time_ago($com['time']);
   
   echo "<div style='background:#000;font-size:11px;padding:10px;width:300px;'><span style='font-style:italic;'><b>$username</b> - Before $time ago. </span> <br /><br /> $message <br /><br /></div>
";
 }
 ?>
 <br style="clear:both" />
</div> <br style="clear:both" />
</div>

<div class="footer_height_add"></div>
<br /> <br style="clear:both" />
<?php } ?>
</div>