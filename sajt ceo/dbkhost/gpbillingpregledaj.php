<?php
if($_SESSION['userid'] == ""){
   die("<script> alert('Ulogujte se prvo.$_SESSION[userid]'); document.location.href='/'; </script>");
}
$id = mysql_real_escape_string(strip_tags($_GET['id']));

if($info['rank'] == '1'){
	if($_GET['action'] == 'delete'){
		mysql_query("DELETE FROM uplate WHERE id='$id'");
		mysql_query("INSERT INTO logovi (datum,text,user,ip) VALUES ('".time()."','obrisao uplatu $id','$_SESSION[username]','".getenv('REMOTE_ADDR')."')");
		echo "<script>window.location='/admin';";
	}
	if($_GET['action'] == 'leglo'){
		$preselect = mysql_query("SELECT userid FROM uplate WHERE id='$id'");
		$preselect_fetch = mysql_fetch_array($preselect);
		mysql_query("UPDATE uplate SET status='1' WHERE id='$id'");
		mysql_query("INSERT INTO notifications (userid,message,link) VALUES ('$preselect_fetch[userid]','Čestitamo! Vaša uplata je primljena.','/gp/billing')") or die(mysql_error());
		mysql_query("INSERT INTO logovi (datum,text,user,ip) VALUES ('".time()."','prihvatio uplatu $id','$_SESSION[username]','".getenv('REMOTE_ADDR')."')");
		echo "<script>window.location='/gp/billing/pregledaj/$id';";
	}
	if($_GET['action'] == 'neleglo'){
		mysql_query("UPDATE uplate SET status='2' WHERE id='$id'");
		mysql_query("INSERT INTO logovi (datum,text,user,ip) VALUES ('".time()."','odbio uplatu $id','$_SESSION[username]','".getenv('REMOTE_ADDR')."')");
		echo "<script>window.location='/gp/billing/pregledaj/$id';";
	}
	if($_GET['action'] == 'cekanje'){
		mysql_query("UPDATE uplate SET status='0' WHERE id='$id'");
		mysql_query("INSERT INTO logovi (datum,text,user,ip) VALUES ('".time()."','na cekanje $id','$_SESSION[username]','".getenv('REMOTE_ADDR')."')");
		echo "<script>window.location='/gp/billing/pregledaj/$id';";
	}
}

$select = mysql_query("SELECT * FROM uplate WHERE id='$id'");
$select_fetch = mysql_fetch_array($select);
if($_SESSION['userid'] != $select_fetch['userid'] and $info['rank'] == '0'){exit('System down:)');}
if($info['rank'] == '1'){
	if($select_fetch['viewed'] == '0'){
		mysql_query("UPDATE uplate SET viewed='1' WHERE id='$id'") or die(mysql_error());
	}
}

?>
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
	
</script>
<div>
	<img src="/img/bilin.png" style="float:left;margin-right:15px;" /> <b>Info centar</b> <br />
	<small>Detaljne informacije o vašoj uplati.</small>
</div>
<br />
<div class="nice_box" style="float:right;width:300px;padding:10px;" >
	<span style="font-size:16px;" ><b>Stanje na računu:</b></span><br />
	<div style="float:right;" class="mali_box">
		<?php echo get_ukupno_kes($select_fetch['userid']); ?> €
	</div><br /><small style="font-size:10px;">Uplate su pretvorene u EURE.</small>
</div>
<style>
ul {
	list-style:none;
}
label {
	margin-right:50px;
}
.testa td{
background: rgba(0,0,0,0.55);
padding:10px;
font-size:14px;
}
.testa td img{
border:solid grey 1px;
padding:3px;
}
</style>
<?php
	if($select_fetch['vrsta_uplate'] == 'bank'){
?>
<table class="testa" style="width:600px;float:left;" >

		<tr>
            <td width="120">Status</td>
			<td><?php echo status_uplate($select_fetch['status']); ?></td>
        </tr>
		<tr>
            <td width="120">Način uplate</td>
			<td><?php echo vrsta_uplate($select_fetch['vrsta_uplate']); ?></td>
        </tr>
		<tr>
            <td width="120">Datum uplate</td>
			<td><?php echo $select_fetch['bank_datum']; ?></td>
        </tr>
		<tr>
            <td width="120">Iznos</td>
			<td><b><?php echo $select_fetch['iznos']; ?> <?php echo $select_fetch['valuta']; ?></b></td>
        </tr>
		<tr>
            <td width="120">Račun</td>
			<td><?php echo $select_fetch['bank_racun']; ?></td>
        </tr>
		<tr>
            <td width="120">Država</td>
			<td><?php echo $select_fetch['bank_drzava']; ?></td>
        </tr>
		<tr>
            <td width="120">Slika uplatnice</td>
			<td><a class="fancybox" href="/<?php echo $select_fetch['bank_uplatnica']; ?>"><img src="/<?php echo $select_fetch['bank_uplatnica']; ?>" width="128" /></a></td>
        </tr>
		<tr>
            <td width="120">Log</td>
			<td><?php echo $select_fetch['log']; ?></td>
        </tr>
		<?php
			if($info['rank'] == '1'){
		?>
		<tr>
            <td width="120">Klijent</td>
			<td><a title="Otvori profil klijenta." style="color:white;text-decoration:none;" href="/user/<?php echo getuser_info($select_fetch['userid']); ?>"><?php echo getuser_info($select_fetch['userid']); ?></a></td>
        </tr>
		<tr>
            <td width="120"><font color=red>Administracija</font></td>
			<td>
			<button style="border:solid red 1px;float:right;" onClick="window.location='/gp/billing/pregledaj/<?php echo $id; ?>/delete';" class="edit_server">Obriši</button>
			
			<?php if($select_fetch['status'] == '0'){ ?>
			<button style="border:solid lightgreen 1px;" onClick="window.location='/gp/billing/pregledaj/<?php echo $id; ?>/leglo';" class="edit_server">Leglo</button>&nbsp;
			<button style="border:solid orange 1px;" onClick="window.location='/gp/billing/pregledaj/<?php echo $id; ?>/neleglo';" class="edit_server">Nije leglo</button>
			<?php } else if($select_fetch['status'] == '1'){ ?>
			<button style="border:solid orange 1px;" onClick="window.location='/gp/billing/pregledaj/<?php echo $id; ?>/cekanje';" class="edit_server">Stavi na čekanje</button>
			<?php } else if($select_fetch['status'] == '2' or $select_fetch['status'] == '3'){ ?>
			<button style="border:solid orange 1px;" onClick="window.location='/gp/billing/pregledaj/<?php echo $id; ?>/cekanje';" class="edit_server">Stavi na čekanje</button>
			<?php } ?>
			</td>
        </tr>
		<?php } ?>
</table>
<?php } ?>
<br style="clear:both" />