<?php
ob_start();

if($_SESSION['userid'] == ""){
   die("<script> alert('You dont have acess'); document.location.href='/'; </script>");
}
?>

<div class="admin_bg">

<h3>Vase notifikacije</h3>

<table class="morph">
<tr>

<th width="450">Poruka</th>
<th width="450">Link</th>

</tr>
<?php

$query_servers = mysql_query("SELECT * FROM notifications WHERE userid='$_SESSION[userid]'  ORDER BY id DESC LIMIT 10 ") or die(mysql_error());
while($row_servers = mysql_fetch_array($query_servers)){
if($row_servers['read'] == 0){$read = "style='color:yellow;'";}else{$read = "style='color:white;'";}
  echo "<tr ><td $read>".$row_servers['message']."</td> <td>".$row_servers['name']." <a href=\"".$row_servers['link']."\">".$row_servers['link']." </a></td>  </tr>";
}
mysql_query("UPDATE `notifications` SET `read` = '1' WHERE userid='$_SESSION[userid]'") or die(mysql_error());
?>
</table>

</div>

<div class="footer_height_add"></div>
<br />