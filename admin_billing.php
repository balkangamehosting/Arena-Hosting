<br />
<?php if($_GET['id']){ ?>
<div style="width:400px;float:left">
	<div class="blokba">Billing za server id <?php echo $_GET['id']; ?></div>
	<?php 
		$pod_qee = mysql_query("SELECT * FROM uplate WHERE placeni_server='".mysql_real_escape_string($_GET['id'])."' ORDER by id desc");
		while($qbaea = mysql_fetch_Array($pod_qee)){

				echo "
				<a href='/gp/billing/pregledaj/$qbaea[id]'>
					<div style='font-size:11px;border-bottom:solid 1px green; margin-bottom:5px;padding-bottom:5px;'>
					<span style='float:right;font-weight:bold;'>".izracunaj($qbaea['id'])." €</span>
						Uplata #$qbaea[id] - <font color=grey>".getuser_info($qbaea['userid'])." - ".status_uplate($qbaea['status'])."</font>
					
					</div>
				</a>
				";
		}
	?>
</div>
<br style="cleaR:both" />
<?php } ?>
<div style="width:400px;float:right">
	<div class="blokba">Lista zadnjih 50 uplata</div>
	<?php 
		$pod_qe = mysql_query("SELECT * FROM uplate WHERE viewed!='0' ORDER by id desc");
		while($qbae = mysql_fetch_Array($pod_qe)){

				echo "
				<a href='/gp/billing/pregledaj/$qbae[id]'>
					<div style='font-size:11px;border-bottom:solid 1px green; margin-bottom:5px;padding-bottom:5px;'>
					<span style='float:right;font-weight:bold;'>".izracunaj($qbae['id'])." €</span>
						Uplata #$qbae[id] - <font color=grey>".getuser_info($qbae['userid'])." - ".status_uplate($qbae['status'])."</font>
					
					</div>
				</a>
				";
		}
	?>
</div>
<style>
a {color:white;text-decoration:none;}
</style>	
<div style="width:500px;">
	<div class="blokba">Lista nepregledanih uplata i uplata na čekanju</div>
	<?php 
		$pod_q = mysql_query("SELECT * FROM uplate WHERE viewed='0' or status='0' ORDER by datum desc");
		while($qba = mysql_fetch_Array($pod_q)){

				echo "
				<a href='/gp/billing/pregledaj/$qba[id]'>
					<div style='background:#000;font-size:11px;padding:10px;width:350px;border:1px solid #008A12;margin-bottom:10px;'>
					<span style='float:right;font-weight:bold;'>".izracunaj($qba['id'])." €</span>
						Uplata #$qba[id] - <font color=grey>".vrsta_uplate($qba['vrsta_uplate'])."</font>
					
					</div>
				</a>
				";
		}
	?>
</div>
<br style="clear:both" />