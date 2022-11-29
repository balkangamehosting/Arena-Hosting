<?php
ob_start();
$id = addslashes(mysql_real_escape_string($_GET['id']));
session_start();
$start = microtime();
include_once("connect_db.php");

$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$_SESSION[userid]'"));
$row = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$id'"));


if($info['rank'] == "0" or $info['rank'] == ""){
  die("<script> alert('You dont have acess'); document.location.href='/'; </script>");
} else {
?>

<?php
if($row['id'] == ""){
   die("<script> alert('Server doesn't exist'); document.location.href='/'; </script>");
} else {
mysql_query("UPDATE servers SET viewed='1' WHERE id='$id'");
?>
<script src="/js/custom.js"></script>
<div class="admin_bg">

<?php
  $kve = mysql_query("SELECT * FROM users WHERE userid='$row[userid]'");
  while($nest = mysql_fetch_array($kve)){
  echo "
  <div class='ref_info'>
  Userid : $nest[userid] <br /><br /> Username : $nest[username] <br /><br /> Email : $nest[email] <br />
  </div><br />
  ";
  }
?>
<?php
	if($row['pay_ref'] == '1'){
		echo "<div style='color:green;background:black;border:solid 1px green;padding:10px;width:150px;text-align:center;'>Plaćeno bodovima! </div>";
	} 
	if($_POST['novi_datum']){
		$novi_datum = mysql_real_escape_string($_POST['novi_datum']);
		if(!empty($novi_datum)){	
			$rowed = str_replace(".", "-", $novi_datum);
			$timestamp = strtotime($rowed);
			
			mysql_query("UPDATE servers SET datum_isteka='$timestamp' WHERE id='$id'");
			echo "<script>window.location='/admin/server_review/$id';</script>";
		} else {
			echo "asd";
		}
		}
?>
<div style="float:right;width:400px;">
	<div class="blokba">Istek servera</div>
	Datum isteka je: <?php echo date("d.m.Y", $row['datum_isteka']); 
	
	$dat_ex = explode(".", date("Y.m.d.", $row['datum_isteka']));

	?>. <br /><br />
	<style>
	.ui-icon ui-icon-circle-triangle-e {
	border: solid 1px black; }
	</style>
	 <script>
$(function() {
 $( "#datepicker" ).datepicker({
showOtherMonths: true,
selectOtherMonths: true
});


$( "#datepicker" ).datepicker( "option", "dateFormat", 'dd.mm.yy' );

$('#datepicker').datepicker("setDate", new Date(<?php echo $dat_ex[0]; ?>,<?php echo $dat_ex[1]; ?>,<?php echo $dat_ex[2]; ?>) );
});
</script>
	<form method="POST" action="">
	<input class="edit_server" style="width:60%" name="novi_datum" value="Klikni ovdje da promjeniš" id="datepicker" ><br /><br />
	<input class="edit_server" style="width:60%;text-align:center;" name="send" type="submit" value="Posalji" id="sad" >
	</form>
	<br />
	<div class="blokba">Billing za ovaj server</div>
	Billing za ovaj server pogledajte <a href="/admin/billing/<?php echo $id; ?>">ovdje.</a>
	
	<br /><br /><br />
	<h3>Uplatnica</h3>
	<?php
		if(!empty($row['uplatnica'])){
			// Prikaz uplatnice
			?>
			<a href="/<?php echo $row['uplatnica']; ?>"><img style="padding:2px;border:solid 1px #02A0A2;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;" src="/<?php echo $row['uplatnica']; ?>" width="300"/></a>
			<?php
		} else {
			// Dodavanje uplatnice
		}
	?>
	
</div>
<?php if($row['status'] == "0"){ 
	$game = $row['game'];

	$query = mysql_query("SELECT port FROM servers WHERE game='$game' ORDER BY ID DESC LIMIT 1") or die(mysql_error());
	$select_last_row_port  = mysql_fetch_array($query);
	$pref_port = $select_last_row_port['port']+1;
?>
<div style="display:none;" id="aktivacija">
	<h3>Unesi informacije za server</h3>
	<style>label {width:130px !important; }</style>
	<form class="test_class" action="/admin_process.php"  method="POST">
	
	<input type="hidden" name="task" value="prihvati_server" /> 
	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" /> 
	
		<label>Igra:</label> 
		<select name="game" id="game" onChange="setMap(this.value);checkPort();">

			<?php 
				$game_s = mysql_query("SELECT id,name,mapa FROM igre WHERE id='$game' ");
				$redba = mysql_fetch_array($game_s);
					echo "<option name='$redba[mapa]' value='$redba[id]'>$redba[name]</option>";
				
			?>
		</select><br />
		<label>Masina:</label> 
		<select name="ip">
			<?php 
				$game_s = mysql_query("SELECT id,name,ip FROM masine Order by id asc");
				while($red = mysql_fetch_array($game_s)){
					echo "<option value='$red[id]'>$red[name] / $red[ip]</option>";
				}
			?>
		</select><br />
		<script src="http://lab.narf.pl/jquery-typing/jquery.typing-0.2.0.min.js"></script>
		<script>
		$( document ).ready(function() {
			
			$("#port").typing({
              start: function () {$(".provjera").html('<font color=orange>Provjeravam...</font>');},
              stop: function () {
			  var game1 = $("#game").val();
			  var port = $("#port").val();
			  var game2 = game1.split("-");
			  var game = game2[0];
				if(game != ''){
				$.ajax({
						type: "GET",
						url: "/ajax.php?page=check_port&game="+game+"&port="+port,
						success: function(ftp){	
							
								$(".provjera").html(ftp);
						},
						error: function(){
							alert('fail');
						}
					});
					}
			  },
              delay: 400
            });
		});
		</script>
		<label>Port:</label> 
		<input type="text"  name="port" id="port" value="<?php echo $pref_port; ?>"></input> <span class="provjera"></span>
		<br />
		<label>Mapa:</label> 
		<input type="text" name="mapa" id="mapa" value="<?php echo $redba['mapa']; ?>"></input>
		<br />
		<button class="edit_server">Aktiviraj!</button>
		<br></br>

	</form>
</div>
<?php } ?>
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

<h3>Admin</h3>
<style>
.admin a{
	color:orange;
	text-decoration:none;
}

</style>
<div class="admin" >
<?php 

#

if($row['status'] == "0"){
	echo "<a href=\"javascript:prikazi('aktivacija');\" >Aktiviraj - </a> ";
}
if($row['status'] == "0"){
echo "
- <a href=\"/admin_process.php?task=odbij_server&id=".$row['id']."\">Odbij -</a> " ; 
} 
if($row['status'] == "1"){
echo "
<a href=\"/admin_process.php?task=odbij_server&id=".$row['id']."\">Suspenduj - </a> " ; 
} 
if($row['status'] == "2"){
echo "
<a href=\"/admin_process.php?task=produzi_server&id=".$row['id']."\">Aktiviraj - </a> " ; 
} 

echo "
<a href=\"/admin_process.php?task=obrisi_server&id=".$row['id']."\">Obrisi </a> " ; 


if($row['status'] == "1"){
echo "
<a href=\"/admin_process.php?task=produzi_server&id=".$row['id']."\"> - Produzi (30 dana)</a> " ; 
}
?>
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
</div>

<div class="footer_height_add"></div>
<br />
<?php } } ?>