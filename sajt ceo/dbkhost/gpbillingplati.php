<?php
if($_SESSION['userid'] == ""){
   die("<script> alert('Ulogujte se prvo.$_SESSION[userid]'); document.location.href='/'; </script>");
}
?>
<script type="text/javascript" src="/js/custom.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
	
</script>
<style>label {width:120px !important;}</style>




<div>
	<img src="/img/bilin.png" style="float:left;margin-right:15px;" /> <b>Pay centar</b> <br />
	<small>Platite Vaše račune u par klikova.</small>
</div>
<br />
<div class="nice_box" style="float:right;width:300px;padding:10px;" >
	<span style="font-size:16px;" ><b>Stanje na računu:</b></span><br />
	<div style="float:right;" class="mali_box">
		<?php echo get_ukupno_kes($_SESSION['userid']); ?> €
	</div><br /><small style="font-size:10px;">Uplate su pretvorene u EURE.</small><br /><br /><br />
	
	<b>Važno!</b><br />
	<small style='color:grey'><code>Naš sistem prilikom plaćanja uzima uplatu sa najmanjim a dovoljnim iznosom za uplatu servera, te nakon toga, novac koji ostaje oduzimanjem se prebaciva na sljedeću uplatnicu tako da Vaš novac, ostaje na Vašem računu.</code></small>
</div>
<style>
ul {
	list-style:none;
}
label {
	margin-right:50px;
}
a {
color:orange;
text-decoration:none;
}
a:hover {color:yellow;}
</style>

		<form enctype="multipart/form-data" action="javascript:;" method="post" class="test_class">

                <ul>


                    <li>
                        <label for="drzava">Izaberite server:</label>

                <select onChange="calculator(this.value);" name="server">
					<option value=''>- Izaberite -</option>
					<?php 
						$game_s = mysql_query("SELECT id,ime_servera FROM servers WHERE userid='$_SESSION[userid]'");
						while($redba = mysql_fetch_array($game_s)){
							echo "<option value='$redba[id]'>$redba[ime_servera]</option>";
						}
					?>
					
				</select>
                    </li><br />
                   <li>
                        <label for="submit" class="topalign">&nbsp;</label>

                        <div class="calculate_info"></div>
                        
                   
                </ul>
               
            </form>
	
<br style="clear:both" />