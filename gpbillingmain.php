<?php
if($_SESSION['userid'] == ""){
   die("<script> alert('Ulogujte se prvo.'); document.location.href='/'; </script>");
}
?>
<script type="text/javascript" src="/js/custom.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
	
</script>
<style>label {width:120px !important;}</style>
<div style="display:none;" id="new_uplata">

	<form class="test_class" method="GET" action="javascript:;">

				<label>Način uplate:</label> 
				<select id="type" name="type">
					<option value='bank'><span style="color:green !important;">Banka/uplatnica</span></option>
					<option value='paypal'>Paypal</option>
				</select><br /><br />

				<label>&nbsp;</label> 
				<button onClick="sendTo();" class="edit_server">Dalje!</button><br /><br />
	</form>
</div>


<div style="float:right" >
	<a href="#new_uplata" class="fancybox"><button class="edit_server"><img style="vertical-align:middle;" src="/img/pp-edit.png"> Dodaj uplatu</button></a>
	<a href="/gp/billing/plati" ><button class="edit_server"><img style="vertical-align:middle;" src="/img/dollar.png"> Plati račune</button></a>
</div>
<div>
	<img src="/img/bilin.png" style="float:left;margin-right:15px;" /> <b>Vaše uplate</b> <br />
	<small>Ispod pregledajte listu Vaših uplata, dodajte novu ili platite server.</small>
</div>
<br />
<div class="nice_box" style="float:right;width:300px;padding:10px;" >
	<span style="font-size:16px;" ><b>Stanje na računu:</b></span><br />
	<div style="float:right;" class="mali_box">
		<?php echo get_ukupno_kes($_SESSION['userid']); ?> €
	</div><br /><small style="font-size:10px;">Uplate su pretvorene u EURE.</small>
</div>

<table style="width:600px;float:left;" id="webftp">

    <tbody>
        <tr>
            <th>ID </th>
			<th>Akcija </th>
            <th>Datum</th>
			<th>Iznos</th>
            <th>Vrsta uplate</th>
            <th>Status</th>

        </tr>
        <?php
			$servers_qba = mysql_query("SELECT * FROM uplate WHERE userid='$_SESSION[userid]' ORDER by ID DESC") or die(mysql_error());
			while($servers_qe = mysql_fetch_array($servers_qba))
			{

			extract($servers_qe);
			
	
		?>
		
		<tr>
			<td><b style="font-size:15px;"><?php echo $servers_qe['id']; ?></b></td>
			<td><a href="/gp/billing/pregledaj/<?php echo $id; ?>">[Otvori]</a></td>
			<td><?php echo date("d.m.Y.", $datum); ?></td>
			<td><?php echo $iznos; ?> <?php echo $valuta; ?></td>
			<td><?php echo vrsta_uplate($vrsta_uplate); ?></td>
			<td><?php echo status_uplate($status); ?></td>

		</tr>
		</a>
		<?php } ?>
    </tbody>

</table>
<br style="clear:both" />
<br style="clear:both" />
<br style="clear:both" />
<br style="clear:both" />