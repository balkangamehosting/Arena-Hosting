<?php


$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$_SESSION[userid]'"));

$getid = mysql_real_escape_string($_GET['id']);

if($getid){
	$ide = $getid;
	$qba = mysql_num_rows(mysql_query("SELECT id FROM tickets WHERE name='$_SESSION[userid]' and id='$ide'"));
}
if($_SESSION['userid'] == ""){
   die("<script> alert('You dont have acess'); document.location.href='/'; </script>");

} 

if($qba == 0 and $info['rank'] == "0" or $info['rank'] == ""){
die("<script> alert('You dont have acess'); document.location.href='/'; </script>");
}
if($info['rank'] != "0"){
mysql_query("UPDATE `tickets` SET `read` = '1', prosledio='0' WHERE id = $getid") or die(mysql_error());
} else {
mysql_query("UPDATE `tickets` SET `read_user` = '1' WHERE id = '$getid'") or die(mysql_error());
}

$get_messages = mysql_fetch_array(mysql_query("SELECT * FROM tickets WHERE id='$getid'"));
if($_SESSION['userid'] == $get_messages['name']){ mysql_query("UPDATE `tickets` SET `read_user` = '1' WHERE id = '$getid'") or die(mysql_error()); }
if(!is_numeric($get_messages['name'])){
	$name = $get_messages['name'];
} else {
$q = mysql_fetch_array(mysql_query("SELECT username,avatar FROM users WHERE userid='$get_messages[name]'"));
$name = "<a style='color:white;' href='/user/".$q['username']."'>".$q['username']."</a>";
$avater = $q['avatar'];
	if(empty($avater)){
		$avater = "/img/userno.png";
	}else {
		$avater = "/avatars/$q[avatar]";
	}
}

$server_info = mysql_fetch_array(mysql_query("SELECT ime_servera FROM servers WHERE id='$get_messages[server]'"));



if($info['rank'] != "0"){
if($_GET['zatvori'] == "1"){

	mysql_query("UPDATE `tickets` SET `closed` = '1' WHERE id = $getid");
	header("Location: /ticket/$getid");
}
if($_GET['prosledi'] == "1"){

	mysql_query("UPDATE `tickets` SET `read` = '0', prosledio='1' WHERE id = $getid");
	header("Location: /tickets");
}
if($_GET['otvori'] == "1"){

	mysql_query("UPDATE `tickets` SET `closed` = '0' WHERE id = $getid");
	header("Location: /ticket/$getid");
}
if($_GET['delete'] == "1"){

	mysql_query("DELETE FROM tickets WHERE id = $getid");
	mysql_query("INSERT INTO logovi (datum,text,user,ip) VALUES ('".time()."','obrisao tiket #$getid','$_SESSION[username]','".getenv('REMOTE_ADDR')."')");
	header("Location: /tickets");
	
}
}
?>


<style>.nav {height:70px;} body {color:whitE;}</style>
			


<h3>Tiket broj #<?php echo $_GET['id']; ?></h3>
<table class="morph" width="100%">
	<tr>
		<th>User</th>
		<th>E-mail</th>
		<th>Vrijeme</th>
		<th>Server</th>
	</tr>
	<tr>
		<td><?php echo $name; ?></td>
		<td><?php echo $get_messages['email']; ?></td>
		<td><?php echo $get_messages['date']; ?></td>
		<td><a href="/gp/server/<?php echo $get_messages['server']; ?>"><?php echo $server_info['ime_servera']; ?></a></td>
	</tr>
	<tr>
		<?php if($info['rank'] != "0"){ if($get_messages['closed'] == "0"){ ?>
		<td><a style='color:orange;' href='/index.php?page=ticket&id=<?php echo $getid; ?>&zatvori=1'>Zatvori</a>&nbsp; - 
		<a style='color:yellow;' href='/index.php?page=ticket&id=<?php echo $getid; ?>&prosledi=1'>Prosledi</a>
		</td>
		<?php } else { ?>
		<td><a style='color:orange;' href='/index.php?page=ticket&id=<?php echo $getid; ?>&otvori=1'>Otvori</a></td>
		<?php } ?>
		<?php 
		if($info['rank'] != "0" or $info['rank'] != ""){
?>
		<td><a style='color:red;' href='/index.php?page=ticket&id=<?php echo $getid; ?>&delete=1'>Obrisi</a></td>
<?php } }
		?>
	</tr>
	
</table>
<br style="clear:both" />
<div class="admin_bg">
<div style="float:right">
<h3>ODGOVORI</h3>
 <?php
	if($_POST['message']){
		$message = mysql_real_escape_string(strip_tags($_POST['message']));
		if($get_messages['email'] != "[Poslano sa profila]"){
			mail($get_messages['email'], "Odgovor na pitanje", $message);
		} else {
		if($info['rank'] == "0"){
			mysql_query("UPDATE `tickets` SET `read` = '0' WHERE id = $getid");
			
		} else {
			mysql_query("UPDATE `tickets` SET `read_user` = '0' WHERE id = $getid");
			mysql_query("INSERT INTO notifications (userid,message,link) VALUES ('$get_messages[name]','Novi odgovor na tiket!','/ticket/$getid')");
		}
			mysql_query("INSERT INTO tickets_reply (ticket_id,name,text,date) VALUES ('$getid','$_SESSION[userid]','$message','".date("d.m.Y - G:i")."')") or die(mysql_error());
		}
	}

	if($get_messages['closed'] != "1"){ ?>
 <form action="" class="iform" id="iform" method="POST">
 <input type="text" name="message" required="required" placeholder="Upisite odgovor..">
 </form>
 <?php } else { ?>
	<h3>Tiket je zatvoren.</h3>
 <?php } ?>
</div>
<h3>PITANJE</h3>
<?php

   
   echo "<div style='background:#000;font-size:11px;padding:10px;width:500px;border-bottom:dashed grey 1px;'>
   <img style='float:lefT;margin-right:15px;' width='54' src='$avater'>
   <span style='font-style:italic;'><b>$name</b> - $get_messages[date] </span> <br /><br /> $get_messages[text] <br /><br /></div>";
   echo "<h3>ODGOVORI</h3>";
   
   $replies_q = mysql_query("SELECT * FROM tickets_reply WHERE ticket_id='$getid' ORDER BY ID DESC LIMIT 10");
   while($redic = mysql_fetch_array($replies_q)){
   extract($redic);
   if(!is_numeric($redic['name'])){
	$name = $redic['name'];
} else {
$q = mysql_fetch_array(mysql_query("SELECT username,avatar FROM users WHERE userid='$redic[name]'"));
$name = "<a style='color:white;' href='/user/".$q['username']."'>".$q['username']."</a>";
$avatar = $q['avatar'];
	if(empty($avatar)){
		$evetar = "/img/userno.png";
	}else {
		$evetar = "/avatars/$q[avatar]";
	}
}
    echo "<div style='background:#000;font-size:11px;padding:10px;width:500px;border:1px solid #008A12;margin-bottom:10px;'>
	<img style='float:lefT;margin-right:15px;' width='54' src='$evetar'>
	<span style='font-style:italic;'><b>$name</b> - $date </span> <br /><br /> $text <br /><br /></div>";
}
 ?>
 <br style="clear:both" />
 
 </div>
<br style="clear:both" />
