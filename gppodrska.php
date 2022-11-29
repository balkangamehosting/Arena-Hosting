<?php
if($_SESSION['userid'] == ""){
   die("<script> alert('Ulogujte se prvo.'); document.location.href='/'; </script>");
}
?>
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
	
</script>
<style>label {width:120px !important;}</style>
<div style="display:none;" id="new_ticket">
<?php
	if($_POST['prioritet']){
		$server 		= mysql_real_escape_string(strip_tags($_POST['server']));
		$prioritet 		= mysql_real_escape_string(strip_tags($_POST['prioritet']));
		$text 		= mysql_real_escape_string(strip_tags($_POST['text']));
		
		if($text != ""){
			mysql_query("INSERT INTO tickets (name,email,text,date,prioritet,server) VALUES ('$_SESSION[userid]', '[Poslano sa profila]', '$text', '".date("d.m.Y. - G:i")."', '$prioritet', '$server')");
		}
	}
?>
	<form class="test_class" method="POST" action="">
		<label>Server:</label> 
		<select name="server">
		
					<?php 
						$game_s = mysql_query("SELECT id,ime_servera FROM servers WHERE userid='$_SESSION[userid]'");
						while($redba = mysql_fetch_array($game_s)){
							echo "<option value='$redba[id]'>$redba[ime_servera]</option>";
						}
					?>
					<option value='27021997'>- Pitanje -</option>
				</select><br /><br />
				<label>Prioritet:</label> 
				<select name="prioritet">
					<option value='0'><span style="color:green !important;">Nije hitno</span></option>
					<option value='1'>Normalni</option>
					<option value='2'>HITNO!</option>
				</select><br /><br />
				<label>Tekst:</label> 
				<textarea style="resize:none;" name="text"></textarea><br /><br />
				<label>&nbsp;</label> 
				<button class="edit_server">Posalji!</button><br /><br />
	</form>
</div>


<div style="float:right" >
	<a href="#new_ticket" class="fancybox"><button class="edit_server"><img style="vertical-align:middle;" src="/img/pp-edit.png"> Novi tiket</button></a>
</div>
<div>
	<img src="/img/ticket.png" style="float:left;margin-right:15px;" /> <b>Vaši tiketi</b> <br />
	<small>Ispod pregledajte listu vaših tiketa.</small>
</div>
<br />

<table id="webftp">

    <tbody>
        <tr>
            <th>ID </th>
            <th width="300">Tekst</th>
			<th>E-Mail</th>
            <th>Datum</th>
            <th>Broj poruka</th>
            <th>Prioritet</th>

        </tr>
        <?php
			$servers_qba = mysql_query("SELECT * FROM tickets WHERE name='$_SESSION[userid]' ORDER by ID DESC LIMIT 200") or die(mysql_error());
			while($servers_qe = mysql_fetch_array($servers_qba))
			{

			extract($servers_qe);
			
			 if($prioritet == "0"){
			  $status = "<span style=\"color:lightgreen;\">Nije hitno</span>";
			} else if($prioritet == "1"){
			  $status = "<span style=\"color:orange;\">Normalni</span>";
			} else if($prioritet == "2"){
			  $status = "<span style=\"color:red;\">Hitno</span>";
			} else {}
			
			$box_name = mysql_num_rows(mysql_query("SELECT id FROM tickets_reply WHERE ticket_id='$servers_qe[id]'"));
		?>
		<tr <?php if($servers_qe['read_user'] == '0'){echo "style='background: none repeat scroll 0% 0% rgba(255, 144, 0, 0.51);'"; } ?>>
			<td>#<?php echo $servers_qe['id']; ?></td>
			<td><a href="/ticket/<?php echo $servers_qe['id']; ?>"><?php echo substr($servers_qe['text'], 0, 50); ?>...</a></td>
			<td><?php echo $email; ?></td>
			<td><?php echo $date; ?></td>
			<td><?php echo $box_name; ?></td>
			<td><?php echo $status; ?></td>
		</tr>
		<?php } ?>
    </tbody>

</table>