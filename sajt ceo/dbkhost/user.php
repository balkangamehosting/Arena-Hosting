<?php
	
	$get_username = mysql_real_escape_string($_GET['username']);
	
	$g_q = mysql_query("SELECT * FROM users WHERE username='$get_username'");
	
	if(empty($get_username) or mysql_num_rows($g_q) == 0){
		die("<script> alert('Not found.'); document.location.href='/'; </script>");
	}
	
	$infos = mysql_fetch_array($g_q);
	
	if($infos['banned'] == "1"){
		$usernejm = "<s style='color:red'>".$infos['username']."</s>";
		$banned = "<a href='/index.php?page=user&username=$get_username&unbanuj=1'>Unbanuj klijenta</a>";
	} else {
		$usernejm = $infos['username'];
		$banned = "<a href='/index.php?page=user&username=$get_username&banuj=1'>Banuj klijenta</a>";
	}
	
	$avatar = $infos['avatar'];
	if(empty($avatar)){
		$avatar = "/img/userno.png";
	}else {
		$avatar = "/avatars/$infos[avatar]";
	}
	
	$last_activity = $infos['last_activity'];
	if($last_activity < time()-350){
		$online = "/img/bullet_black.png";
	} else {
		$online = "/img/bullet_green.png";
	}
	$bodovi = mysql_num_rows(mysql_query("SELECT id FROM points WHERE userid='$infos[userid]'"));
	$last_activity = time_ago($infos['last_activity']);
	
	$servera = mysql_num_rows(mysql_query("SELECT id FROM servers WHERE userid='$infos[userid]'"));
	
	if($infos['rank'] == "1"){$rank= "Admin";}else {$rank="Klijent";}
	
	if($info['rank'] == "1"){
		if($_GET['banuj'] == "1"){
			mysql_query("UPDATE users SET banned='1' WHERE userid='$infos[userid]'");
			header("Location: /user/$get_username");
		}
		if($_GET['unbanuj'] == "1"){
			mysql_query("UPDATE users SET banned='0' WHERE userid='$infos[userid]'");
			header("Location: /user/$get_username");
		}
	}
	if($_GET['bocni'] == "1" and $info['userid'] != $infos['userid']){
			mysql_query("INSERT INTO notifications (userid,message,link) VALUES ('$infos[userid]','$_SESSION[username] vas je bocnuo!','/user/$_SESSION[username]')");
			header("Location: /user/$get_username");
		}
	
?>
<style>
	.nav {height:90px;}
	.avatar {padding:3px; border:solid 0px grey;margin-left:20px;}
	.centriraj div {text-align:left;}
	.block_title {
		border-bottom: 1px solid #358f50;
		color: #358f50;
		font-size: 14px;
		line-height: 31px;
		margin-bottom: 10px;
		padding-left: 20px;
		text-transform: uppercase;
		font-family: Arial,Helvetica,sans-serif;
		font-weight: 700;
	}
	table {font-family:calibri;color:#c4c4c4;}
	td {border-bottom:solid #2b7a44 1px;padding:4px;}
	td:nth-child(2) {text-align:center;font-weight:bold;}
	td a {color:#c4c4c4;text-decoration:none;}
</style>
<div class="admin_bg">
	<div class="gt_title_srv">
		<img src="<?php echo $online; ?>" /><?php echo $usernejm; ?>
	</div>
	<br />
	<center class="centriraj">
		<div style="width:300px;float:left;margin-right:10px;">
		<div class="block_title">AVATAR <?php if($infos['userid'] == $info['userid']){echo "<a href='/user/edit' style='color:grey;text-decoration:none;'>[promjeni]</a>";} ?></div>
			<img class="avatar" src="<?php echo $avatar; ?>" width="250"/><br />
			<div class="block_title">REFERRAL LINK</div>
			<div class="test_123_1">
			<input type="text" onclick="this.select();" value="http://<?php echo $_SERVER['HTTP_HOST']; ?>/referal/give_point/<?php echo $_SESSION['userid']; ?>">
			</div>
		</Div>
		<div style="width:300px;float:left;margin-right:10px;">
			<div class="block_title">USER INFO <?php if($infos['userid'] == $info['userid']){echo "<a href='/user/edit' style='color:grey;text-decoration:none;'>[izmjeni]</a>";} ?></div>
			<table>
				<tr>
					<td width="150">ID</td>
					<td width="150"><?php echo $infos['userid']; ?></td>
				</tr>
				<tr>
					<td width="150">Ime i prezime</td>
					<td width="150"><?php echo $infos['ime']." ".$infos['prezime'] ; ?></td>
				</tr>
				<tr>
					<td>Bodovi</td>
					<td><?php echo $bodovi; ?></td>
				</tr>
				<tr>
					<td>Zadnja aktivnost</td>
					<td>prije <?php echo $last_activity; ?></td>
				</tr>
				<tr>
					<td>Registrovan</td>
					<td><?php echo substr($infos['register_time'],0,10); ?></td>
				</tr>
				<tr>
					<td>Rank</td>
					<td><?php echo $rank; ?></td>
				</tr>
			</table>
		</Div>
		<div style="width:300px;float:left;margin-right:10px;">
			<div class="block_title">SERVERS INFO</div>
			<table>
				<tr>
					<td width="150">Servera</td>
					<td width="150"><?php echo $servera; ?></td>
				</tr>
			</table><br /><br /><br />
			<?php if($_SESSION['userid'] != ""){ ?>
			<div class="block_title">AKCIJE</div>
			<table>
				<tr>
					<td width="300"><a href="/index.php?page=user&username=<?php echo $get_username; ?>&bocni=1">Bocni korisnika</a></td>
				</tr>
				<?php if($info['rank'] == "1"){ ?>
				<tr>
					<td width="300"><?php echo $banned; ?></td>
				</tr>
				<?php } ?>
				
			</table>
			<?php } ?>
		</Div>
	</center>
	<br style="clear:both" />
</div>
<br style="clear:both" />