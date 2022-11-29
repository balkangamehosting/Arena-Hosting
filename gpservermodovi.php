<?php
if($_SESSION['userid'] == ""){
   die("<script> alert('Ulogujte se prvo.'); document.location.href='/'; </script>");
}
?>
<table id="webftp">
<script src="/js/custom.js"></script>
    <tbody>
        <tr>
            <th>Ime moda</th>
            <th width="500">Opis moda</th>
            <th>Default mapa</th>
            <th>Opcije</th>
            
        </tr>
        <?php
			$servers_qba = mysql_query("SELECT * FROM modovi WHERE game='$select_fetch[game]'  ORDER by ID DESC LIMIT 200") or die(mysql_error());
			while($servers_qe = mysql_fetch_array($servers_qba))
			{

			
			
		?>
		<tr>
			<td><a href="#" ><?php echo $servers_qe['ime']; ?></a></td>
			<td><?php echo $servers_qe['opis']; ?></td>
			<td><?php echo $servers_qe['mapa']; ?></td>
			<?php if($select_fetch['gamemod'] == $servers_qe['id']){ ?>
			<td><a  href="javascript:;" style="color:green;"><img style='vertical-align:middle;' src='/img/download.png' />&nbsp;&nbsp; Instalirano</a></td>
			<?php } else { ?>
			<td><a  href="javascript:installmod('<?php echo $id; ?>','<?php echo $servers_qe['id']; ?>');"><img style='vertical-align:middle;' src='/img/download.png' />&nbsp;&nbsp; Instaliraj</a></td>
			<?php } ?>
		</tr>
		<?php } ?>
    </tbody>

</table>