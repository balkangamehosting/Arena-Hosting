<?php
if($_SESSION['userid'] == ""){
   die("<script> alert('Ulogujte se prvo.'); document.location.href='/'; </script>");
}
?>
<div style="float:right;width:600px;">
Vijesti<br /><br />

<?php 
	$sl = mysql_query("SELECT * FROM news ORDER by ID DESC LIMIT 5");
	while($s = mysql_fetch_array($sl)){
?>
<div id="user_info" style="width:550px;">
	<span style="float:right"><?php echo $s['datum']; ?></span>
	<span style="color:orange" ><b><?php echo $s['naslov']; ?></b></span><br /><br />
	<?php echo $s['text']; ?>
</div>
<?php } ?>
<br />
</div>
Vaše informacije<br /><br />
<div id="user_info" >
<img src="/img/userid.png" />
	<br /><?php echo $_SESSION['username']; ?><br />
	<span style="color:orange" ><?php echo $infoba['email']; ?></span><br />
	<span style="color:grey" >Servera: <?php echo mysql_num_rows(mysql_query("SELECT id FROM servers WHERE userid='$_SESSION[userid]' and status='1'")); ?></span>
	
	<br style="clear:both" />
</div>