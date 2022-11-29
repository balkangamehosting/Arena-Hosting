<?php
if($_SESSION['userid'] == ""){
   die("<script> alert('Ulogujte se prvo.'); document.location.href='/'; </script>");
}
?>
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
	
</script>

<script src="/js/custom.js" ></script>
<div style="display:none;font-family:calibri;width:300px;" id="ftp_password">
<form method="post" class="test_class" action="javascript:getPassword(<?php echo $id; ?>);">
	<center>Molimo unesite Vaš PIN kod:</center><br /><br />
		<center><input style="font-size:25px;width:70px;padding:5px;text-align:center;height:30px;" type="text" name="pin" id="pin_code" placeholder="****" >
<br /><br />
<input type="submit" class="edit_server" style="font-size:16px;padding:5px;height:30px;" name="send_pin" value="Posalji" >		</center>
	</form>
</div>
<div style="display:none;font-family:calibri;width:300px;" id="reinstal">
<form method="post" class="test_class" action="javascript:reinstallCheck(<?php echo $id; ?>);">
	<center>Molimo unesite Vaš PIN kod:</center><br /><br />
		<center><input style="font-size:25px;width:70px;padding:5px;text-align:center;height:30px;" type="text" name="pin" id="pin_code2" placeholder="****" >
<br /><br />
<input type="submit" class="edit_server" style="font-size:16px;padding:5px;height:30px;" name="send_pin" value="Posalji" >		</center>
	</form>
</div>



<div style="float:right;width:600px;">
<div class="akcije" style="font-size:15px;" >
		<b>FTP podaci</b>
		<br />
		<div style="float:right;margin-top:30px;width:260px;">
			<a href="#ftp_password" class="fancybox"><button class="edit_server">Prikaži FTP šifru</button></a>
		</div>
		<table class="infos" style="font-size:14px;margin-top:10px;">
			<tr>
				<td width="100"><span style="color:orange" ><img src="/img/pp-slots.png" /> IP adresa:</span></td>
				<td><?php echo $box_name['ip']; ?></td>
			</tr>
			<tr>
				<td ><span style="color:orange" ><img src="/img/pp-user.png" /> Username:</span></td>
				<td><?php echo $select_fetch['ftp_username']; ?></td>
			</tr>
			<tr>
				<td ><span style="color:orange" ><img src="/img/pp-key.png" /> Password:</span></td>
				<td><font class="ftppass" color=red>[skriven]</font> <?php if($info['rank'] != '0'){ echo $select_fetch['ftp_password']; } ?></td>
			</tr>
			<tr>
				<td ><span style="color:orange" ><img src="/img/pp-port.png" /> Port:</span></td>
				<td>21</td>
			</tr>
			
		</table>
	</div>
	<br /><br />
<div class="akcije" style="font-size:15px;" >
		<b>Status servera </b>
		<br />
		<div style="float:right;margin-top:30px;width:260px;">
		<?php 
		if($data['server_'.$id]['gq_online'] == "0"){
		?>
			<button onClick="window.location='/server_process.php?task=start&id=<?php echo $id; ?>';mrak();" class="edit_server"><img class="imgbut" src="/img/pp-start.png" /> Start</button> 
		<?php
		} else {
		?>
			<button onClick="window.location='/server_process.php?task=stop&id=<?php echo $id; ?>';mrak();" class="edit_server"><img class="imgbut" src="/img/pp-stop.png" /> Stop</button>
		<?php } ?>
			&nbsp;<button onClick="window.location='/server_process.php?task=restart&id=<?php echo $id; ?>';mrak();" class="edit_server"><img class="imgbut" src="/img/pp-restart.png" /> Restart</button> 
		</div>
		<table class="infos" style="font-size:14px;margin-top:10px;">
			<tr>
				<td width="100"><span style="color:orange" ><img src="/img/pp-onof.png" /> Status:</span></td>
				<td><?php echo $live_status; ?></td>
			</tr>
			<tr>
				<td ><span style="color:orange" ><img src="/img/pp-map.png" /> Mapa:</span></td>
				<td><?php echo $live_map; ?></td>
			</tr>
			<tr>
				<td ><span style="color:orange" ><img src="/img/pp-user.png" /> Igrači:</span></td>
				<td><?php echo $live_players; ?> / <?php echo $live_max_players; ?></td>
			</tr>
			<tr>
				<td ><span style="color:orange" ><img src="/img/pp-hom.png" /> Ime:</span></td>
				<td><?php echo $live_name; ?></td>
			</tr>
			
		</table>
	</div>
	<br style="clear:both" />
	<style>
		.line {
			width:5px;
		}
		#akcijeba ul li {

    margin-right: 15px;
}
	</style>
	<script>
		function prosvijetliMe(){
			$("#akcijeba").css('opacity', '1');
		}
		function odsvijetliMe(){
			$("#akcijeba").css('opacity', '0.45');
		}
	</script>
	<div id="akcijeba" style="opacity:0.45" onMouseOver="prosvijetliMe();"  onMouseOut="odsvijetliMe();" class="akcije">
			<ul>
			<?php
				if($game_fetch['protocol'] == 'halflife'){
			?>
					<li><a href="/gp/server/<?php echo $id; ?>/webftp/&url=/cstrike/addons/amxmodx/plugins"><img width="12" src="/img/pp-folder.png" />Plugins</a></li>
					<li class="line">/</li>
					<li><a  href="/gp/server/<?php echo $id; ?>/webftp/&url=/cstrike/addons/amxmodx/configs" ><img width="12" src="/img/pp-folder.png" />Configs</a></li>
					<li class="line">/</li>
					<li><a  href="/gp/server/<?php echo $id; ?>/webftp/&url=/cstrike/maps" ><img width="12" src="/img/pp-folder.png" />Maps</a></li>
					<li class="line">/</li>
					<li><a  href="/gp/server/<?php echo $id; ?>/webftp/edit/cstrike/server.cfg"><img width="8" src="/img/pp-file.png" />server.cfg</a></li>
					<li class="line">/</li>
					<li><a href="/gp/server/<?php echo $id; ?>/webftp/edit/cstrike/addons/amxmodx/configs/users.ini"><img width="8" src="/img/pp-file.png" />users.ini</a></li>
					<li class="line">/</li>
					<li><a href="/gp/server/<?php echo $id; ?>/webftp/edit/cstrike/addons/amxmodx/configs/plugins.ini"><img width="8" src="/img/pp-file.png" />plugins.ini</a></li>
				<?php } else if($game_fetch['protocol'] == 'samp'){ ?>
				<li><a  href="#"><b>Prečice</b></a></li>
				<li class="line">/</li>
				<li><a  href="/gp/server/<?php echo $id; ?>/webftp/edit/server.cfg"><img width="8" src="/img/pp-file.png" />server.cfg</a></li>
				<li class="line">/</li>
				<li><a  href="/gp/server/<?php echo $id; ?>/webftp/edit//server_log.txt"><img width="8" src="/img/pp-file.png" />server_log.txt</a></li>
				<?php } ?>

			</ul>
				<br style="clear:both" />
		</div>
</div>
<div style="width:300px;">
	<div class="akcije" style="font-size:15px;" >
		<b>Informacije o serveru </b>
		<br />
		<table class="infos" style="font-size:14px;margin-top:10px;">
			<tr>
				<td width="120"><span style="color:orange" ><img src="/img/pp-hom.png" /> Ime:</span></td>
				<td><?php echo $select_fetch['ime_servera']; ?></td>
			</tr>
			<tr>
				<td ><span style="color:orange" ><img src="/img/pp-map.png" /> Def. mapa:</span></td>
				<td><?php echo $select_fetch['default_map']; ?></td>
			</tr>
			<tr>
				<td ><span style="color:orange" ><img src="/img/pp-game.png" /> Igra:</span></td>
				<td><?php echo get_game_name($select_fetch['game']); ?></td>
			</tr>
			<tr>
				<td ><span style="color:orange" ><img src="/img/pp-mod.png" /> Mod:</span></td>
				<td><?php if($select_fetch['gamemod'] =='public'){ echo "Public"; } else { echo get_mod_name($select_fetch['gamemod']); } ?></td>
			</tr>
			<tr>
				<td ><span style="color:orange" ><img src="/img/pp-date.png" /> Važi do:</span></td>
				<td><?php echo date("d.m.Y", $select_fetch['datum_isteka']); ?> <small>(još <?php echo countdown($select_fetch['datum_isteka']); ?>)</small></td>
			</tr>
		</table>
	</div>
	<br />
	<div class="akcije" style="font-size:15px;" >
		<b>Informacije o serveru</b>
		<br />
		<table class="infos" style="font-size:14px;margin-top:10px;">
			<tr>
				<td width="100"><span style="color:orange" ><img src="/img/pp-location.png" /> Lokacija:</span></td>
				<td><?php echo $box_name['name']."/".$box_name['location']; ?></td>
			</tr>
			<tr>
				<td ><span style="color:orange" ><img src="/img/pp-ip.png" /> Slotovi:</span></td>
				<td><?php echo $select_fetch['slots']; ?></td>
			</tr>
			<tr>
				<td ><span style="color:orange" ><img src="/img/pp-slots.png" /> IP Adresa:</span></td>
				<td><?php echo $box_name['ip'].":".$select_fetch['port']; ?></td>
			</tr>
			<tr>
				<td ><span style="color:orange" ><img src="/img/pp-status.png" /> Status:</span></td>
				<td><?php echo $status; ?></td>
			</tr>
			
		</table>
	</div>
</div><br style="clear:both" />
	