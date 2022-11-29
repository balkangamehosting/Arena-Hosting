<?php
session_start();
$start = microtime();
include_once("connect_db.php");

$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$_SESSION[userid]'"));

if($info['rank'] == "0" or $info['rank'] == ""){
   die("<script> alert('You dont have acess'); document.location.href='/'; </script>");
} else {
?>

<div class="admin_bg">

<div class="space1"></div>
<style>
ul#admin_menu li {
		border: 1px solid #353535;
		float: left;
		margin: 5px;
		overflow: hidden;
		padding: 10px 5px;
		text-align: center;
		width: 76px;
		list-style:none;
	}

	ul#admin_menu .title {
		color: white;
		display: block;
		font-family: arial;
		font-size: 10px;
		padding: 10px 0;
		
	}
	ul#admin_menu a {
	text-decoration:none;
	}
</style>
<?php
$new_orders = mysql_num_rows(mysql_query("SELECT id FROM servers WHERE `viewed` = '0'"));
$new_ticketsb = mysql_num_rows(mysql_query("SELECT id FROM tickets WHERE `read` = '0'"));
$new_billingsb = mysql_num_rows(mysql_query("SELECT id FROM uplate WHERE `viewed` = '0'"));

   if($new_orders != 0 ){
   $new_orders_count = '<sub class="admin_new">'.$new_orders.'</sub>';
   }
   if($new_ticketsb != 0){
   $new_tickets_count = '<sub class="admin_new">'.$new_ticketsb.'</sub>';
   }
   if($new_billingsb != 0){
   $new_billing_count = '<sub class="admin_new">'.$new_billingsb.'</sub>';
   }
   
echo '<div class="grid_24">';
		echo '<ul id="admin_menu">';
		echo '
			<li>
				<a href="/admin">
					<span><img class="ico" src="/img/48x48/home.png" alt="home" /></span>
					<span class="title">Admin Home</span>
				</a>
			</li>
		';
		echo '
			<li>
				<a href="/admin/narudzbe">
					<span><img class="ico" src="/img/48x48/basket.png" alt="orders" /></span>
					<span class="title">Narudzbe'.$new_orders_count.'</span>
				</a>
			</li>
		';
		echo '
			<li>
				<a href="/admin/communities">
					<span><img class="ico" src="/img/48x48/basket.png" alt="reseller" /></span>
					<span class="title">Communities'.$new_reseller_count.'</span>
				</a>
			</li>
		';
		echo '
			<li>
				<a href="/admin/servers">
					<span><img class="ico" src="/img/48x48/basket.png" alt="reseller" /></span>
					<span class="title">GT Servers'.$new_reseller_count.'</span>
				</a>
			</li>
		';
		echo '
			<li>
				<a href="/admin/tickets">
					<span><img class="ico" src="/img/48x48/mail.png" alt="tickets" /></span>
					<span class="title">Tickets'.$new_tickets_count.'</span>
				</a>
			</li>
		';
		if($info['rank'] == '1'){
			echo '
				<li>
					<a href="/admin/blockip">
						<span><img class="ico" src="/img/48x48/shield.png" alt="block ip" /></span>
						<span class="title">Block IP</span>
					</a>
					</li>
			';
		
			
			echo '
				<li>
					<a href="/admin/kupon">
						<span><img class="ico" src="/img/48x48/wallet2.png" alt="budget" /></span>
						<span class="title">Budget</span>
					</a>
				</li>
			';
		echo '
				<li>
					<a href="/admin/box">
						<span><img width="48" class="ico" src="/img/masine.png" alt="budget" /></span>
						<span class="title">Mašine</span>
					</a>
				</li>
		';
		echo '
				<li>
					<a href="/admin/igre">
						<span><img width="48" class="ico" src="/img/igre.png" alt="budget" /></span>
						<span class="title">Igre</span>
					</a>
				</li>
		';
		echo '
				<li>
					<a href="/admin/modovi">
						<span><img width="48" class="ico" src="/img/mods.png" alt="budget" /></span>
						<span class="title">Modovi</span>
					</a>
				</li>
		';
		echo '
				<li>
					<a href="/admin/plugini">
						<span><img width="48" class="ico" src="/img/plugini.png" alt="budget" /></span>
						<span class="title">Plugini</span>
					</a>
				</li>
		';
		echo '
			<li>
				<a href="/admin/billing">
					<span><img class="ico" src="/img/cash.png" alt="orders" /></span>
					<span class="title">Billing'.$new_billing_count.'</span>
				</a>
			</li>
		';
		}
		echo '</ul>';
		echo '</div>';

?>

<br  style="clear:both" />

<?php
define("access", 1);

if($_GET['p'] == "admin_servers"){
   include("admin_servers.php");
} else if($_GET['p'] == "edit_server"){
   include("admin.edit_server.php");
} else if($_GET['p'] == "admin_kupons"){
   include("admin_kupons.php");
} else if($_GET['p'] == "admin_tickets"){
   include("admin_tickets.php");
} else if($_GET['p'] == "admin_communities"){
   include("admin_communities.php");
}  else if($_GET['p'] == "narudzbe"){
   include("admin_narudzbe.php");
}  else if($_GET['p'] == "box"){
   include("admin_box.php");
}  else if($_GET['p'] == "igre"){
   include("admin_igre.php");
}  else if($_GET['p'] == "modovi"){
   include("admin_modovi.php");
}  else if($_GET['p'] == "plugini"){
   include("admin_plugini.php");
}  else if($_GET['p'] == "blockip"){
   include("admin_blockip.php");
}  else if($_GET['p'] == "billing"){
   include("admin_billing.php");
} else {
?>
<br />
<div style="width:400px;float:right;">
<?php 
	if($_POST['dodaj_podsjetnik']){
		if(!empty($_POST['tekst'])){
			$txt = mysql_real_escape_string(strip_tags($_POST['tekst']));
			mysql_query("INSERT INTO notes (admin,datum,text) VALUES ('$_SESSION[userid]', '".time()."', '$txt')");
		}
	}
?>
<div class="blokba" >Podsjetnici</div>
	<form class="test_class" method="post" action="" >
		<textarea name="tekst" style="resize:none;" ></textarea>
		<input style="padding:15px;" type="submit" name="dodaj_podsjetnik" value="Dodaj" />
	</form>
	<br />
	<?php
		$pod_q = mysql_query("SELECT * FROM notes ORDER by ID desc LIMIT 3");
		while($qba = mysql_fetch_Array($pod_q)){
		$q = mysql_fetch_array(mysql_query("SELECT username,avatar FROM users WHERE userid='$qba[admin]'"));
$name = "<a style='color:white;' href='/user/".$q['username']."'>".$q['username']."</a>";
$avatar = $q['avatar'];
	if(empty($avatar)){
		$evetar = "/img/userno.png";
	}else {
		$evetar = "/avatars/$q[avatar]";
	}
				echo "<div style='background:#000;font-size:11px;padding:10px;width:350px;border:1px solid #008A12;margin-bottom:10px;'>
				<img style='float:lefT;margin-right:15px;' width='54' src='$evetar'>
				<span style='font-style:italic;'><b>$name</b> - ".date("d.m.Y", $qba['datum'])." </span> <br /><br /> $qba[text] <br /><br /></div>";
		}
	?>
	<br style="clear:both" />
</div>

<div style="width:500px;">
<div class="blokba" title="manje od 7 dana">GameHost računi koji ubrzo ističu</div>
<ul class="fatlist" style="max-height: 250px;">
					<?php
					
					$gameorders_query = mysql_query("SELECT id,game,datum_isteka,datum_isteka-UNIX_TIMESTAMP() as datum_is FROM servers WHERE datum_isteka-UNIX_TIMESTAMP() < 604800 AND status='1' ORDER BY datum_is DESC, id DESC");
					while($gameorders_row = mysql_fetch_assoc($gameorders_query)){
						
						$even_odd = ( 'odd' != $even_odd ) ? 'odd' : 'even';
						$time_r = countdown($gameorders_row['datum_isteka'], "istekao");
						
						echo '
								<li class="noborder '.$even_odd.'">
									<span class="flw180"><a  href="/admin/server_review/'.$gameorders_row['id'].'">#'.$gameorders_row['id'].' '.get_game_name($gameorders_row['game']).'</a></span>
									<span class="flw130">'.$time_r.' </span>
									<span class="flw125">'.date("d.m.Y", $gameorders_row['datum_aktivacije']).'</span>
								</li>
							';
							
					}
					?>
			</ul>
			
			<br />
			
			<div class="blokba" title="manje od 7 dana">Logovi</div><ul class="fatlist" style="max-height: 250px;font-size:12px;">
			<?php
					
					$gameorders_query = mysql_query("SELECT * FROM logovi ORDER by ID desc LIMIT 100");
					while($gameorders_row = mysql_fetch_assoc($gameorders_query)){
						
						$even_odd = ( 'odd' != $even_odd ) ? 'odd' : 'even';
						$time_r = time_ago($gameorders_row['datum']);
						
						echo '
								<li class="noborder '.$even_odd.'">
									<span class="flw180">'.$gameorders_row['text'].'</span>
									<span class="flw90">'.$time_r.'</span>
									<span class="flw90">'.$gameorders_row['user'].'</span>
									<span class="flw90">'.$gameorders_row['ip'].'</span>
								</li>
							';
							
					}
					?>
					</ul>
</div>
<br style="clear:both" />
<?php
}
?>

</div>

<div class="footer_height_add"></div>
<br />
<?php } ?>