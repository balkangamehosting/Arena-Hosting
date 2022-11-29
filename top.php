<?php


?>

<div class="admin_bg">


<style>
	th {text-align:left;border-bottom:solid whitesmoke 1px;padding:5px;}
	td {padding:5px;border-bottom:solid grey 1px;}
</style>
  <h3>TOP 20</h3> 
    <table>
		<th width="15">No.</th>
		<th width="150">Username</th>
		<th width="150">Bodovi</th>
		
		<?php
			$i=0;
			$w = mysql_query("SELECT 
    users.userid,users.username, COUNT(points.id) as total_messages
FROM 
    users
INNER JOIN 
    points ON points.userid = users.userid
GROUP BY 
    userid
ORDER BY 
    COUNT(points.id) DESC LIMIT 40") or die(mysql_error());
			while($red = mysql_fetch_array($w)){
			$i++;
			$aasd = mysql_num_rows(mysql_query("SELECT id FROM points WHERE userid='$red[userid]'"));
				echo "<tr>
						<td><small>$i</small></td>
						<td><a style='color:white;' href='/user/$red[username]'>$red[username]</a></td>
						<td>$aasd</td>
					  </tr>	";
			}
		?>
	</table>

</div>


<div class="footer_height_add"></div><br />

