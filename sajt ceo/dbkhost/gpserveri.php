<?php
if($_SESSION['userid'] == ""){
   die("<script> alert('Ulogujte se prvo.'); document.location.href='/'; </script>");
}
?>
<div>
	<img src="/img/tv.png" style="float:left;margin-right:15px;" /> <b>Vaši serveri</b> <br />
	<small>Ispod pregledajte listu vaših AKTIVNIH servera.</small>
</div>
<br />

<table id="webftp">

    <tbody>
        <tr>
            <th>Ime servera</th>
            <th>Aktivan do</th>
            <th>Cijena</th>
            <th>IP adresa</th>
            <th>Igra</th>
            <th>Slotovi</th>
            <th>Status</th>
        </tr>
        <?php
			$servers_qba = mysql_query("SELECT * FROM servers WHERE status!='0' AND userid='$_SESSION[userid]' ORDER by ID DESC LIMIT 200") or die(mysql_error());
			while($servers_qe = mysql_fetch_array($servers_qba))
			{

			extract($servers_qe);
			
			 if($status == "1"){
			  $status = "<span style=\"color:lightgreen;\">Aktivan</span>";
			} else if($status == "2"){
			  $status = "<span style=\"color:red;\">Suspendovan</span>";
			} else {}
			
			$box_name = mysql_fetch_array(mysql_query("SELECT ip FROM masine WHERE id='$servers_qe[box]'"));
		?>
		<tr>
			<td><a href="/gp/server/<?php echo $id; ?>" ><?php echo $servers_qe['ime_servera']; ?></a></td>
			<td><?php echo date("d.m.Y", $datum_isteka); ?></td>
			<td><?php echo $price; ?> €</td>
			<td><?php echo $box_name['ip']; ?>:<?php echo $servers_qe['port']; ?></td>
			<td><?php echo get_game_name($game); ?></td>
			<td><?php echo $slots; ?></td>
			<td><?php echo $status; ?></td>
		</tr>
		<?php } ?>
    </tbody>

</table>