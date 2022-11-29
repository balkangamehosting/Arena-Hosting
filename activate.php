<?php
ob_start();
$id = addslashes($_GET['id']);
session_start();
$start = microtime();
include_once("connect_db.php");

$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$_SESSION[userid]'"));
$row = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$id' and userid='$_SESSION[userid]'"));


?>

<?php
if($row['id'] == ""){
   die("<script> alert('Server doesn't exist'); document.location.href='/'; </script>");
} else {
?>
<style>.clear{clear:both;} </style>
<div class="admin_bg">
	<script type="text/javascript">
function show_form_bank(){
	$('#bank_payment_form').show('slow');
	$('#paypal_payment_form').hide('slow');
	$('#onebip_payment_form').hide('slow');
	$('#refs_payment_form').hide('slow');
}
function show_form_paypal(){
	$('#bank_payment_form').hide('slow');
	$('#paypal_payment_form').show('slow');
	$('#onebip_payment_form').hide('slow');
	$('#refs_payment_form').hide('slow');
}

function show_form_refs(){
	$('#bank_payment_form').hide('slow');
	$('#paypal_payment_form').hide('slow');
	$('#onebip_payment_form').hide('slow');
	$('#refs_payment_form').show('slow');
}
</script>


<div class="container_24">

	<div class="grid_24">
		<div class="content_block">
			<div class="blokba">

    Odaberi način plaćanja:

</div>
			<center>
				<a href="javascript:;" onClick="show_form_bank()">
					<img id="giro_button" src="/img/giro_badge.png" alt="bank" />
				</a>
				
				<a href="javascript:;" onClick="show_form_paypal()">
					<img id="paypal_button" src="/img/paypal_badge.png" alt="paypal" />
				</a>
				
				
				
				<a href="javascript:;" onClick="show_form_refs()">
					<img id="onebip_button" src="/img/points_badge.png" alt="points" />
				</a>
			</center>
		</div>
		<!-- end .content_block -->
		<div class="clear"></div>
		
		
		<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>
		
		
		<div class="content_block" id="bank_payment_form" style="display:none;">
			<div class="blokba">1. KORAK</div>
				Pogledaj kako treba izgledati tvoja uplatnica:
				<br />
				<a class="fancybox" rel="group" href="/slip-generator/bih/game/<?php echo $id; ?>.png"><img src="/files/images/ico/32x32/bosnia_and_herzegovina.png" alt="Bosna i Hercegovina" /></a>
				
				<a class="fancybox" href="/slip-generator/rs/game/<?php echo $id; ?>.png"><img src="/files/images/ico/32x32/serbia.png" alt="Srbija" /></a>

				
				<br /><br />
				<a class="fancybox" href="/slip-generator/other/game/<?php echo $order_id; ?>.png">(ukoliko se vaša država ne nalazi na listi kliknite ovdje)</a>
			<br /><br /><br />
			
			
			<div class="blokba">2. KORAK</div>
				Izvrši uplatu na naš žiro račun
			<br /><br /><br />
			
			<div class="blokba">3. KORAK</div>
				Uslikaj uplatnicu koju si dobio nakon uplate
			<br /><br /><br />
			
			<div class="blokba">4. KORAK</div>
				Sliku uplatnice uploadaj putem ovog formulara
			<br /><br /><br />

			
			<form class="test_class" method="POST" enctype="multipart/form-data" action="/process.php?task=nova_uplatnica&serverid=<?php echo $id; ?>">
		<label><br />Uploadujte novu sliku uplatnice:</label><br /><br /> <input type="file" name="uplatnica" accept="image/jpeg,image/png" required="required"> <br /><div class="space_contact1"></div> <br />
		<button class="edit_server">Upload!</button>
	</form>
			<br style="clear:both" />
		</div>
		<!-- end .content_block -->
		<br style="clear:both" />
		<div class="clear"></div>
		
		
		
		
		
		<div class="content_block" id="paypal_payment_form" style="display:none;">
			
			<div class="block_title">1. korak</div>
				<a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=mys.53m1r@gmail.com&lc=BA&item_name=<?php echo urlencode($order_game.' - '.$order_location.' - '.$order_slots.' slots'); ?>&amount=<?php echo $order_price; ?>&amp;currency_code=EUR&button_subtype=services&bn=PP-BuyNowBF:btn_paynow_SM.gif:NonHosted">
					klikni na ovaj link i izvrši uplatu na naš paypal račun
				</a>
			<br /><br /><br />
				
				
			<div class="block_title">2. korak</div>
				upiši id narudžbe(Transaction ID) koji si dobio nakon uplate
			<br /><br /><br />
			
			<a target="_blank" href="#" style="float:right;">
					<img src="/files/images/misc/paypal_verified.png" alt="we are verified on paypal" />
			</a>
			
			<form action="" method="POST" class="fatform" style="float:left;">
				<p>
					<label for="image">Transaction ID</label>
					<input id="transaction_id" type="text" name="transaction_id">
				</p>
				<p>
					<input class="submit_button" type="submit" name="update_transaction_id" value="Aktiviraj" />
				</p>
			</form>
		</div>
		<!-- end .content_block -->
		<div class="clear"></div>
		
		
		
		
		
		<!-- end .content_block -->
		<div class="clear"></div>
		
		
		
		
		
		<div class="content_block" id="refs_payment_form" style="display:none;">
			
			
			<?php
				if($_POST['yes']){
					if($get_q2  >= $refs_needed){
						mysql_query("UPDATE servers SET pay_ref='1' WHERE id='$id'") or die(mysql_error());
						mysql_query("DELETE FROM points WHERE userid='$get_q[userid]' LIMIT $refs_needed") or die(mysql_error());
						$_SESSION['ok'] = "Uspjesno placeno! Sacekajte administratora da odobri.";
						echo "<script>alert('Uspjesno placeno! Sacekajte administratora da odobri.');window.location='/index.php'</script>";
						
					
					}
				}
		
			?>
			
			
			
			<?php  if($get_q2 < $refs_needed){echo '<div style="color:red;">nemaš dovoljno bodova (potrebno '.$refs_needed.' a ti imaš '.$get_q2.')</div>';} else {
			
			
			?> 
			<div class="blokba">Sigurno želiš platiti preko bodova (<?php echo $refs_needed; ?>) ?</div>
			<style>input:hover {background:darkgreen;cursor:pointer;} form {padding:10px;font-size:16px;}</style>
			<form action="" method="POST" class="fatform">
			
				
					<input  type="submit" name="yes" value="Da" />
					
					<input  type="submit" name="pay_by_refs_no" value="Ne" />
					<br style="clear:both" />
				
				
			</form>
			<br style="clear:both" />
			<?php }  ?>

			
			

			
			
		</div>
		<!-- end .content_block -->
		<div class="clear"></div>
		
		
		
	</div>
	<!-- end .grid_24 -->
	
</div>
<!-- end .container_24 -->

</div>
</div>

<div class="footer_height_add"></div>
<br />
<?php } ?>