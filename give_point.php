<?php
$userid = addslashes($_GET['userid']);

$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$userid'"));

if($info['userid'] == ""){
   die("<script> alert('Korisnik koga trazite ne postoji.'); document.location.href='/'; </script>");
}
?>

<div class="admin_bg">

<center><h2>DA LI STE SIGURNI DA ZELITE DA DATE BOD KORISNIKU <br /> <b><span style="color:green;"><?php echo $info['username']; ?></span></b></h2>
<br />

<form action="/process.php?task=give_point" method="POST">
<input type="hidden" name="userid" value="<?php echo $info['userid']; ?>">
<input type="submit" class="po_da" value="DA">
<a href="/index.php"><input type="button"  class="po_ne" value="NE" disabled="disabled" /></a>
</form>

</center>
</div>

<div class="footer_height_add"></div>
<br />
