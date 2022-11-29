<?php
	if(!isset($_SESSION['username'])){exit;}
		$g_qba = mysql_query("SELECT * FROM users WHERE username = '$_SESSION[username]'") or die(mysql_error());

	
	
	
	$infos = mysql_fetch_array($g_qba);
	
	
	
	$avatar = $infos['avatar'];
	if(empty($avatar)){
		$avatar = "/img/userno.png";
	}else {
		$avatar = "/avatars/$infos[avatar]";
	}
	
	if($_POST['avatar']){
	
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
		<?php echo $_SESSION['username']; ?>
	</div>
	<br />
	<center class="centriraj">
		<div style="width:300px;float:left;margin-right:10px;">
		<div class="block_title">AVATAR</div>
			<img class="avatar" src="<?php echo $avatar; ?>" width="250"/><br />
			
		</Div>
		<div style="width:300px;float:left;margin-right:10px;">
			<div class="block_title">PROMJENI AVATAR</div>
			<form class="test_class" method="POST" enctype="multipart/form-data" action="/process.php?task=novi_avatar">
				<input type="file" name="avatar" accept="image/jpeg,image/png" required="required"> <br /><div class="space_contact1"></div> <br />
				<button class="edit_server">Upload!</button>
			</form><br />
			<div class="block_title">OBRISI AVATAR</div>
			<form class="test_class" method="POST" enctype="multipart/form-data" action="/process.php?task=reset_avatar">
				
				<button class="edit_server">Resetuj avatar!</button>
			</form>
		</Div>
		<div style="width:300px;float:left;margin-right:10px;">
			<div class="block_title">USER INFO</div>
			<form class="test_class" method="POST" enctype="multipart/form-data" action="/process.php?task=edit_name">
				<input type="text" name="ime" value="<?php echo $infos['ime']." ".$infos['prezime']; ?>"><br /><br />
				
				<button class="edit_server">Promjeni!</button><br />
				<small>* Format ide: Ime (razmak) Prezime</small>
			</form><br />
			<div class="block_title">PASSWORD</div>
			<form class="test_class" method="POST" enctype="multipart/form-data" action="/process.php?task=edit_pw">
				<input type="password" placeholder="Trenutni password.." name="trenutni" ><br />
				<input type="password" placeholder="Novi password.." name="novi" ><br /><br />
				
				<button class="edit_server">Promjeni!</button><br />

			</form>
		</Div>
	</center>
	<br style="clear:both" />
</div>
<br style="clear:both" />