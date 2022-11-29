<?php defined("access") or die("Nedozvoljen pristup");

if($info['rank']!= '1'){exit();} 

$submit_block = $_POST['block_ip'];
	if($submit_block){
		$post_ip		= mysql_real_escape_string($_POST['ip']);
		$post_reason	= mysql_real_escape_string($_POST['reason']);
		if(strlen($post_ip) < 39 && strlen($post_ip) > 10){
			if(strlen($post_reason) < 120){
				if(mysql_num_rows(mysql_query("SELECT ip FROM blocked_ips WHERE ip='$post_ip'"))==0){
					$block_ip = mysql_query("INSERT INTO blocked_ips (id,ip,reason,created) VALUES ('','$post_ip','$post_reason','".time()."')");
					if($block_ip){
						header("Location: /admin/blockip");
					}	 else {
						$_SESSION['error'] = '<div class="error">Greška</div>';
					}
				} else {
					$_SESSION['error'] = '<div class="error">IP je vec dodan</div>';
				}
			} else {
				$_SESSION['error'] = '<div class="error">Predugačak razlog</div>';
			}
		} else {
			$_SESSION['error'] = '<div class="error">IP adresa nije validna</div>';
		}
	}

?>
<div class="container_24">

		<div style="width:49%;float:right">
		<div class="content_block">
			<div class="blokba">Block ip</div>
			<form class="test_class" method="POST" action="">
				<p>
					<label for="ip">IP</label>
					<input id="ip" type="text" name="ip" value="<?php echo htmlspecialchars($post_ip);?>" />
				</p>
				<p>
					<label for="reason">Razlog</label>
					<input id="reason" type="text" name="reason" value="<?php echo htmlspecialchars($post_reason);?>" />
				</p>
				<p>
					<input class="submit_button" type="submit" name="block_ip" value="Block" />
				</p>
			</form>
		</div>
		<!-- end .content_block -->
		<div class="clear"></div>
	</div>

	<div style="width:49%;">
		<div class="content_block">
			<div class="blokba">Blokirane IP adrese</div>
			<ul class="fatlist" style="max-height: 350px;">
			<?php
				$ips_query = mysql_query("SELECT * FROM blocked_ips ORDER BY id DESC");
				while($ips_row = mysql_fetch_assoc($ips_query)){
					$ip			= $ips_row['ip'];
					$reason		= $ips_row['reason'];
					$created	= date("d.m.Y H:i",$ips_row['created']);
					$even_odd = ( 'odd' != $even_odd ) ? 'odd' : 'even';
					echo '
						<li class="noborder '.$even_odd.'">
							<span class="flw180">'.$ip.'</span>
							<span class="flw125" title="'. htmlspecialchars($reason) .'">'.$created.'</span>
						</li>
					';
				}
			?>
			</ul>
		</div><br style="clear:both" />
		<!-- end .content_block -->
		<div class="clear"></div><br style="clear:both" /><br style="clear:both" />
	</div><br style="clear:both" />
	<br style="clear:both" />
	<!-- end .grid_12 -->
	
	

	<!-- end .grid_12 -->
	<div class="clear"></div>
	<br style="clear:both" />
</div><br style="clear:both" />
<!-- end .container_24 -->
