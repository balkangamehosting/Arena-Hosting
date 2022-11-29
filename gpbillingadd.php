<?php
if($_SESSION['userid'] == ""){
   die("<script> alert('Ulogujte se prvo.$_SESSION[userid]'); document.location.href='/'; </script>");
}
?>
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
	
</script>
<style>label {width:120px !important;}</style>

<?php
	$s = mysql_fetch_array(mysql_query("SELECT id FROM servers WHERE userid='$_SESSION[userid]'"));
	$ids = $s['id'];
?>


<div>
	<img src="/img/bilin.png" style="float:left;margin-right:15px;" /> <b>Dodaj uplatu</b> <br />
	<small>Pratite uputstva za dodavanje nove uplatnice/transakcije.</small>
</div>
<br />
<div class="nice_box" style="float:right;width:300px;padding:10px;" >
	<span style="font-size:16px;" ><b>Stanje na računu:</b></span><br />
	<div style="float:right;" class="mali_box">
		<?php echo get_ukupno_kes($_SESSION['userid']); ?> €
	</div><br /><small style="font-size:10px;">Uplate su pretvorene u EURE.</small>
	<br /><br /><br /><br />
	<img id="giro_button" src="/img/giro_badge.png" alt="bank" />
	<br /><br />
	<small style="color:White;font-weight:bold;">Kliknite na državu da vidite primjer uplatnice!</small>
	<a class="fancybox" rel="group" href="/slip-generator/bih/game/<?php echo $ids; ?>.png"><img src="/files/images/ico/32x32/bosnia_and_herzegovina.png" alt="Bosna i Hercegovina" /></a>
				
				<a class="fancybox" href="/slip-generator/rs/game/<?php echo $ids; ?>.png"><img src="/files/images/ico/32x32/serbia.png" alt="Srbija" /></a>
</div>
<style>
ul {
	list-style:none;
}
label {
	margin-right:50px;
}
</style>
<?php
	$type = $_GET['type'];
	
	if($type == 'bank'){
	?>
		<form enctype="multipart/form-data" action="/billing_process.php?task=add" method="post" class="test_class">

                <ul>
                    <li>
                        <label for="iznos">Uplaćen iznos:</label>

                        <input type="text" style="width:100px;" title="Iznos koji ste uplatili." required="required" name="iznos" id="iznos" value=""/>
						<select style="width:80px;float:right;margin-right:200px;" name="valuta" id="valuta">
                            <option value="DIN">DIN</option>
							<option value="EUR">EUR</option>
							<option value="KM">KM</option>
							<option value="MKD">MKD</option>
                        </select>
                    </li><br />
                    <li>
                        <label for="uplatioc">Ime uplatioca:</label>

                        <input type="text" title="Ime lica koje je uplatilo." required="required" name="uplatioc" id="uplatioc" value=""/>
                       
                    </li><br />
                    <li>
                        <label for="datum">Datum uplate:</label>

                        <input type="text" title="Datum kada ste uplatili, u formatu dan.mjesec.Godina (21.06.2014.)" required="required" name="datum" id="datum" />
                       
                    </li><br />
                    <li>
                        <label for="racun">Broj računa:</label>

                        <input type="text" title="Broj računa na koji ste uplatili." required="required" name="racun" id="racun" />
                        
                    </li><br />

                    <li>
                        <label for="drzava">Država:</label>

                        <select name="drzava" id="drzava">
                            <option value="Srbija">Srbija</option>
							<option value="Bosna i Hercegovina">Bosna i Hercegovina</option>
							<option value="Hrvatska">Hrvatska</option>
							<option value="Makedonija">Makedonija</option>
							<option value="Crna Gora">Crna Gora</option>
                        </select>
                    </li><br />
                    <li>
                        <label for="uplatnica" class="topalign">Slika uplatnice:</label>

                        <input type="file" name="uplatnica" title="Na uplatnici se sve informacije trebaju vidjeti jasno.">
                        
                    </li><br />
                    <li>
                        <label for="submit" class="topalign">&nbsp;</label>

                        <button  class="edit_server">Dodaj!</button>
                        
                    </li><br />
                </ul>
               
            </form>
	<?php
	} else if($type == 'paypal'){
	?>
	
	<?php
	}
?>
<br style="clear:both" />