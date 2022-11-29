<?php
if($_SESSION['userid'] == ""){
   die("<script> alert('Ulogujte se prvo.'); document.location.href='/'; </script>");
}
?>
<table id="webftp">
<script src="/js/custom.js"></script>
    <tbody>
        <tr>
            <th>Ime plugina</th>
            <th width="500">Opis plugina</th>
            <th>Opcije</th>
            
        </tr>
        <?php
			$servers_qba = mysql_query("SELECT * FROM plugins WHERE game='$select_fetch[game]'  ORDER by ID DESC LIMIT 200") or die(mysql_error());
			while($servers_qe = mysql_fetch_array($servers_qba))
			{

			
			
		?>
		<tr>
			<td><a href="#" ><?php echo $servers_qe['ime']; ?></a></td>
			<td><?php echo $servers_qe['opis']; ?></td>

			<td><a  href="/server_process.php?task=plugininstal&server=<?php echo $id; ?>&modid=<?php echo $servers_qe['id']; ?>"><img style='vertical-align:middle;' src='/img/download.png' />&nbsp;&nbsp; Instaliraj</a></td>
		</tr>
		<?php } ?>
    </tbody>

</table>